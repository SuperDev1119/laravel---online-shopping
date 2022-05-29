<?php

namespace App\Services\UpdateSources;

use App\Models\Source;

class Flexoffers extends BaseSource
{
	protected $requiredEnvParams = [
		'FLEXOFFERS_FTP_USER',
		'FLEXOFFERS_FTP_PASS',
	];

	const CATALOG_FILE_NAME = 'Catalog.xml';
	const FTP_FEEDS_ROOT = 'ProductFeeds/XML';

	private $ftpHost;
	private $ftpUser;
	private $ftpPass;
	private $ftpClient;

	public function __construct()
	{
		$this->ftpHost = config('imports.FLEXOFFERS.HOST');
		$this->ftpUser = config('imports.FLEXOFFERS.USER');
		$this->ftpPass = config('imports.FLEXOFFERS.PASS');

		$this->ftpClient = ftp_connect($this->ftpHost);
		ftp_login($this->ftpClient, $this->ftpUser, $this->ftpPass);
		ftp_pasv($this->ftpClient, true);
	}

	public function update()
	{
		$feedFolders = ftp_nlist($this->ftpClient, self::FTP_FEEDS_ROOT);

		if (!$feedFolders) {
			return error_log('[-] Cannot update Sources from Flexoffers: cannot get folders');
		}

		foreach ($feedFolders as $folder) {
			$subFolders = ftp_nlist($this->ftpClient, $folder);

			foreach ($subFolders as $subFolder) {
				$feeds = ftp_nlist($this->ftpClient, $subFolder);

				$catalog = null;
				$feeds = collect($feeds)->reject(function ($item) use (&$catalog) {
					if ($is_catalog = self::CATALOG_FILE_NAME == basename($item)) {
						$catalog = $item;
					}

					return $is_catalog;
				});

				if (! $catalog) {
					continue;
				}

				if (! $xml = simplexml_load_string(file_get_contents($this->get_url($catalog)))) {
					echo '[-] Cannot read XML file '.print_r($catalog, true);
					continue;
				}

				$feedName = $xml->name;
				$country = $xml->country;

				foreach ($feeds as $feed) {
					$this->update_source(
						$feedName,
						$feedName,
						$this->get_url($feed),
						$xml,
						[
							'language' => 'Region:'.$country,
						],
					);
				}
			}
		}
	}

	private function get_url($path)
	{
		return 'ftp://'
		. urlencode($this->ftpUser)
		. ':'. $this->ftpPass
		. '@'. $this->ftpHost
		. '/'. $path;
	}
}

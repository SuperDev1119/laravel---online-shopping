<?php

namespace App\Libraries;

class Cloudinary
{
    public static function get($image_url, $size = '', $seo_file_name = null)
    {
        $image_url = str_replace([
            'https:https:',
            'https:/cdn-images',
        ], [
            'https:',
            'https://cdn-images',
        ], $image_url);

        if (! empty($size)) {
            $size .= '/';
        }

        $thumbor_urls = config('app.thumbor_urls');
        $seed = strlen($image_url) + ord(substr($image_url, -5));
        $server_id = $seed % count($thumbor_urls);
        $thumbor_url = $thumbor_urls[$server_id];

        if ($seo_file_name) {
            $seo_file_name .= '-'.config('app.site_name').'.jpg';
        } else {
            $seo_file_name = basename($image_url);
        }

        return 'https://'.$thumbor_url.'/unsafe/'.$size.base64_encode($image_url).'_/'.$seo_file_name;
    }

    public static function forGrid($image_url, $_options = [])
    {
        $options = array_merge([
            'retina' => false,
            'seo-file-name' => null,
        ], $_options);

        $size = $options['retina'] ? '0x500' : '0x250';

        return static::get($image_url, $size, $options['seo-file-name']);
    }
}

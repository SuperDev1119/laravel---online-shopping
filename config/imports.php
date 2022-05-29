<?php

return [
    'SCRAPINGHUB_API_KEY' => env('SCRAPINGHUB_API_KEY', false),
    'SHOW_DEBUG' => env('APP_IMPORT_SHOW_DEBUG', false),
    'PRODUCT_STORE_PAYLOAD' => env('APP_IMPORT_PRODUCT_STORE_PAYLOAD', false),
    'AWIN' => [
        'DATAFEEDS' => env('AWIN_DATAFEEDS')
    ],
    'EFFILIATION' => [
        'API_KEY' => env('EFFILIATION_API_KEY')
    ],
    'NETAFFILIATION' => [
        'FEEDS_URL' => env('NETAFFILIATION_FEEDS_URL')
    ],
    'IMPACT' => [
        'SID' => env('IMPACT_SID'),
        'TOKEN' => env('IMPACT_TOKEN')
    ],
    'TRADEDOUBLER' => [
        'SITE_ID' => env('TRADEDOUBLER_SITE_ID'),
        'API_TOKENS' => explode(',', env('TRADEDOUBLER_API_TOKENS'))
    ],
    'ML' => [
        'USER' => env('ML_USER'),
        'PASS' => env('ML_PASS')
    ],
    'CJ' => [
        'USER' => env('CJ_USER'),
        'PASS' => env('CJ_PASS'),
        'CATALOG_ID' => env('CJ_CATALOG_ID'),
        'HTTP' => [
            'USER' => env('CJ_HTTP_USER'),
            'PASS' => env('CJ_HTTP_PASS')
        ]
    ],
    'DAISYCON' => [
        'USER' => env('DAISYCON_USER'),
        'PASS' => env('DAISYCON_PASS'),
    ],
    'FLEXOFFERS' => [
        'USER' => env('FLEXOFFERS_FTP_USER'),
        'PASS' => env('FLEXOFFERS_FTP_PASS'),
        'HOST' => env('FLEXOFFERS_FTP_HOST', 'ftp.flexoffers.com')
    ],
    'PARTNERIZE' => [
        'LOGIN' => env('PARTNERIZE_API_LOGIN'),
        'PASS' => env('PARTNERIZE_API_PASSWORD')
    ],
    'RAKUTEN' => [
        'USER' => env('RAKUTEN_USER'),
        'PASS' => env('RAKUTEN_PASS'),
        'SID_NUMBER' => env('RAKUTEN_SID_NUMBER'),
        'FTP' => [
            'USER' => env('RAKUTEN_FTP_USER'),
            'PASS' => env('RAKUTEN_FTP_PASS'),
            'HOST' => env('RAKUTEN_FTP_HOST')
        ],
        'CONSUMER' => [
            'KEY' => env('RAKUTEN_CONSUMER_KEY'),
            'SECRET' => env('RAKUTEN_CONSUMER_SECRET')
        ]
    ],
    'TRADETRACKER' => [
        'AID' => env('TRADETRACKER_AID'),
        'CID' => env('TRADETRACKER_CID'),
        'LOGIN' => env('TRADETRACKER_LOGIN'),
        'PASS' => env('TRADETRACKER_PASS')
    ]
];

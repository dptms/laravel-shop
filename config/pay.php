<?php

return [
    'alipay' => [
        'app_id' => env('ALIPAY_APP_ID'),
        'ali_public_key' => env('ALIPAY_ALI_PUBLIC_KEY'),
        'private_key' => env('ALIPAY_PRIVATE_KEY'),
        'log' => [
            'file' => storage_path('logs/alipay.log'),
        ],
        'notify_url' => env('ALIPAY_NOTIFY_URL'),
    ],

    'wechat' => [
        'appid' => env('WECHAT_APP_ID'),
        'mch_id' => env('WECHAT_MCH_ID'),
        'key' => env('WECHAT_KEY'),
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key' => resource_path('wechat_pay/apiclient_key.pem'),
        'log' => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
        'notify_url' => env('WEACHAT_NOTIFY_URL'),
    ],
];
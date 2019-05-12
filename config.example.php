<?php

return [
    'restream' => [
        'clientId'                => '',    // The client ID assigned to you by the provider
        'clientSecret'            => '',   // The client password assigned to you by the provider
		'redirectUri'             => '',
        'urlAuthorize'            => '',
        'urlAccessToken'          => '',
        'urlResourceOwnerDetails' => ''

    ],
    'database' => [
        'connection' => 'mysql:host=localhost',
        'database' => '',
        'username' => '',
        'password' =>'',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];

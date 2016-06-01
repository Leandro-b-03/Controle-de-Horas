<?php

return [
    'plugins' => [
        'adldap' => [
            'account_suffix'     => '@someideias.local',
            'domain_controllers' => [
                '192.168.80.128'
            ], // Load balancing domain controllers
            'base_dn' => 'DC=someideias,DC=local',
            'admin_username' => 'timesheet', // 'timesheet', // This is required for session persistance in the application
            'admin_password' => 'NGxJrOVf9DwT9VMJYix1', // '7DFWT)EVu6',
            'use_ssl' => false, // If TLS is true this MUST be false.
            'use_tls' => false, // If SSL is true this MUST be false.
        ],
    ],
];
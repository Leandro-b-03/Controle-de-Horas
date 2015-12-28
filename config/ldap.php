<?php

return array(
    'plugins' => array(
        'adldap' => array(
            'account_suffix'=>  '@svlabs.local',
            'domain_controllers'=>  array(
                'dc2.svlabs.local'
            ), // Load balancing domain controllers
            'base_dn' => 'DC=svlabs,DC=local',
            'admin_username' => 'timesheet', // This is required for session persistance in the application
            'admin_password' => '7DFWT)EVu6',
            'use_ssl' => false, // If TLS is true this MUST be false.
            'use_tls' => false, // If SSL is true this MUST be false.
        ),
    ),
);
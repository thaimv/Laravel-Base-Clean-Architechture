<?php

return [
    'default_page' => 1,
    'per_page' => 10,
    'fe_url' => env('FE_URL', 'localhost'),
    'password_reset_token_expired' => 24,

    // Date formats (naming: {type}_{format_pattern})
    'date_format' => [
        'datetime_Y_m_d_H_i_s' => 'Y-m-d H:i:s',
        'date_Y_m_d' => 'Y-m-d',
        'time_H_i_s' => 'H:i:s',
        'datetime_d_m_Y_H_i_s' => 'd/m/Y H:i:s',
        'date_d_m_Y' => 'd/m/Y',
    ],

    'mail' => [
        'reset_password' => [
            'subject' => 'Reset Your Password',
            'template' => 'emails/forgot-password',
        ],
    ],
];

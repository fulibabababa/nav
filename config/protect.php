<?php

return [
    'env'               => env('MOCK_ENV'),
    'max_failure_times' => 2,
    'crontab'           => [
        'check_pending_per_time' => 2,
        'check_success_per_time' => 1,
    ],
    'email'             => 'keerdh@gmail.com'
];
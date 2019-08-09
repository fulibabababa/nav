<?php

return [
    'env'               => env('MOCK_ENV'),
    'max_failure_times' => env('MAX_FAILURE_TIMES', 2),
    'crontab'           => [
        'check_pending_per_time' => env('CHECK_PENDING_PER_TIME', 1),
        'check_success_per_time' => env('CHECK_SUCCESS_PER_TIME', 1),
    ],
    'email'             => env('PROJECT_EMAIL','xxx@gmail.com')
];
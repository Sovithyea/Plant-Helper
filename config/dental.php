<?php

return [
    'procedure' => [
        'status' => [
            'recommend' => 1,
            'accepted' => 2,
            'pending' => 3,
        ]
    ],
    'appointment' => [
        'status' => [
            'active' => 1,
            'completed' => 2,
            'cancelled' => 3,
        ],
        'text' => [
            1 => 'Active',
            2 => 'Completed',
            3 => 'Cancelled',
        ],
        'color' => [
            1 => 'primary',
            2 => 'success',
            3 => 'error'
        ]
    ]
];
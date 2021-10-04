<?php
namespace App\Traits;

trait OrderStatus
{
    protected $statues = [
        [
            'text' => 'Pending'
        ],
        [
            'text' => 'Processing'
        ],
        [
            'text' => 'Delivering'
        ],
        [
            'text' => 'Delivered'
        ],
        [
            'text' => 'Canceled'
        ]
    ];

    public function status($type = 'text')
    {
        return $this->statues[$this->status][$type];
    }
}
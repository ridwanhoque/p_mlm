<?php
namespace App\Contracts;

interface ShouldUseStatus
{
    public function status($type = 'text');
}
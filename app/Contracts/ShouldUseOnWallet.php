<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface ShouldUseOnWallet
{
    public function transaction() : MorphOne;
}
<?php
namespace App\Contracts;

interface ShouldUseInCart
{
    public function price($isFormatter = true, $emiPrice = false);

    public function firstImagePath($isUseSmall = true);

    public function permalink();

    public function deliveryPriceDhaka();

    public function deliveryPriceOutDhaka();

    public function commission($emiPrice = false);

    public function availableEmi();
}

<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\ViewModel;

use Magento\Catalog\Model\Product;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use MylSoft\StationarySale\Helper\Config;

class StationarySale implements ArgumentInterface
{
    public function __construct(
        private Config $config,
    ) {
    }

    /**
     * @param Product $product
     * @return bool
     */
    public function getShow(Product $product): bool
    {
        $configShow = $this->config->getShow();
        $productShow = (bool)$product->getStationarySale();

        return $configShow && $productShow;
    }
}
<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    public const CONFIG_PATH = 'catalog/stationary_sale/';
    public const CONFIG_SHOW = 'show';

    public function __construct(
        private ScopeConfigInterface $scope
    ) {
    }

    /**
     * @return bool
     */
    public function getShow(): bool
    {
        return (bool)$this->scope->getValue(
            self::CONFIG_PATH . self::CONFIG_SHOW,
            ScopeInterface::SCOPE_STORE
        );
    }
}
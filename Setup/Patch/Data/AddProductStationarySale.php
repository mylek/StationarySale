<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\Setup\Patch\Data;

use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;

class AddProductStationarySale implements DataPatchInterface, PatchRevertableInterface
{
    public const STATIONARY_SALE = 'stationary_sale';

    public function __construct(
        private EavSetupFactory $eavSetupFactory,
        private ModuleDataSetupInterface $moduleDataSetup,
    ) {
    }

    public static function getDependencies(): array
    {
        return [];
    }

    public function getAliases(): array
    {
        return [];
    }

    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create();

        $eavSetup->removeAttribute(Product::ENTITY, self::STATIONARY_SALE);
        $eavSetup->addAttribute(
            Product::ENTITY,
            self::STATIONARY_SALE,
            [
                'type' => 'int',
                'label' => __('Stationary Sale'),
                'default' => false,
                'input' => 'text',
                'source' => Boolean::class,
                'required' => true,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'searchable' => true,
                'filterable' => true,
                'comparable' => true,
                'used_in_product_listing' => true,
                'visible' => true,
                'group' => 'General',
            ]
        );

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function revert(): void
    {
    }
}
<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\Test\Integration\ViewModel;

use Magento\TestFramework\TestCase\AbstractController;
use Magento\Catalog\Model\ProductRepository;

/**
 * @magentoAppIsolation enabled
 * @magentoAppArea frontend
 * @magentoDbIsolation enabled
 * @magentoDataFixture loadFixture
 */
class StationarySaleTest extends AbstractController
{
    private ?ProductRepository $productRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->productRepository = $this->_objectManager->get(ProductRepository::class);
    }

    /**
     * @magentoConfigFixture current_store catalog/stationary_sale/show 1
     * @magentoDataFixture loadFixture
     * @return void
     */
    public function testGetShowSetStationarySaleTrue(): void
    {
        $product = $this->productRepository->get('simple_product_1');
        $this->dispatch(sprintf('catalog/product/view/id/%s', $product->getEntityId()));
        $this->assertStringContainsString((string)__('Stationary Sale'), $this->getResponse()->getBody());
    }

    /**
     * @magentoConfigFixture current_store catalog/stationary_sale/show 0
     * @return void
     */
    public function testGetShowSetStationarySaleConfigFalse(): void
    {
        $product = $this->productRepository->get('simple_product_1');
        $this->dispatch(sprintf('catalog/product/view/id/%s', $product->getEntityId()));
        $this->assertStringNotContainsString((string)__('Stationary Sale'), $this->getResponse()->getBody());
    }

    /**
     * @magentoConfigFixture current_store catalog/stationary_sale/show 1
     * @return void
     */
    public function testGetShowSetStationarySaleFalse(): void
    {
        $product = $this->productRepository->get('simple_product_1');
        $product->setStationarySale(false);
        $this->productRepository->save($product);

        $this->dispatch(sprintf('catalog/product/view/id/%s', $product->getEntityId()));
        $this->assertStringNotContainsString((string)__('Stationary Sale'), $this->getResponse()->getBody());
    }

    /**
     * @return void
     */
    public static function loadFixture(): void
    {
        include __DIR__ . '/../_files/stationary_sales_product.php';
    }
}
<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\Test\Unit\ViewModel;

use MylSoft\StationarySale\ViewModel\StationarySale;
use PHPUnit\Framework\TestCase;
use MylSoft\StationarySale\Helper\Config;
use Magento\Catalog\Model\Product;

class StationarySaleTest extends TestCase
{
    private StationarySale $stationarySale;

    private Config $config;

    public function setUp(): void
    {
        $this->config = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->stationarySale = new StationarySale($this->config);
    }

    /**
     * @return void
     * @dataProvider getShowProvider
     */
    public function testGetShow(bool $expected, bool $returnConfig, bool $returnProduct): void
    {
        $this->config->expects($this->once())->method('getShow')->willReturn($returnConfig);
        $productMock = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStationarySale'])
            ->getMock();
        $productMock
            ->expects($this->any())
            ->method('getStationarySale')
            ->willReturn($returnProduct);

        $this->assertEquals($expected, $this->stationarySale->getShow($productMock));
    }

    /**
     * @return array
     */
    public function getShowProvider(): array
    {
        return [
            [true, 'returnConfig' => true, 'returnProduct' => true],
            [false, 'returnConfig' => false, 'returnProduct' => true],
            [false, 'returnConfig' => true, 'returnProduct' => false],
            [false, 'returnConfig' => false, 'returnProduct' => false],
        ];
    }
}
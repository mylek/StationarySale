<?php

declare(strict_types=1);

namespace MylSoft\StationarySale\Test\Unit\Helper;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Model\ScopeInterface;
use MylSoft\StationarySale\Helper\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    private Config $config;

    private ScopeConfigInterface $scopeConfig;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMockForAbstractClass();

        $this->config = new Config($this->scopeConfig);
    }

    /**
     * @return void
     * @dataProvider getShowProvider
     */
    public function testGetShow(bool $expected, bool $return): void
    {
        $this->scopeConfig->expects($this->once())
            ->method('getValue')
            ->willReturn($return);

        $this->assertEquals($expected, $this->config->getShow());
    }

    /**
     * @return array
     */
    public function getShowProvider(): array
    {
        return [
            [true, true],
            [false, false],
        ];
    }
}
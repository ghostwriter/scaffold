<?php

declare(strict_types=1);

namespace Tests\Unit\Container\Ghostwriter\Config;

use Ghostwriter\Container\Interface\ContainerInterface;
use Ghostwriter\Container\Interface\Service\ExtensionInterface;
use Ghostwriter\Scaffold\Container\Ghostwriter\Config\ScaffoldConfigurationExtension;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\AbstractTestCase;

use const DIRECTORY_SEPARATOR;

use function dirname;
use function is_a;

#[CoversClass(ScaffoldConfigurationExtension::class)]
final class ScaffoldConfigurationExtensionTest extends AbstractTestCase
{
    public function testImplementsExtensionInterface(): void
    {
        self::assertTrue(is_a(ScaffoldConfigurationExtension::class, ExtensionInterface::class, true));
    }

    public function testInvokeMergesConfigurationFromProjectRoot(): void
    {
        $container = $this->createMock(ContainerInterface::class);
        $container->expects(self::never())->method('get')->seal();

        $configuration = $this->createMock(ScaffoldConfigurationInterface::class);
        $configuration->expects(self::once())
            ->method('mergeDirectory')
            ->with(dirname(__DIR__, 5) . DIRECTORY_SEPARATOR . 'config')
            ->seal();

        (new ScaffoldConfigurationExtension())($container, $configuration);
    }
}

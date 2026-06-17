<?php

declare(strict_types=1);

namespace Tests\Unit\Container;

use Ghostwriter\Config\Interface\ConfigurationInterface;
use Ghostwriter\Container\Interface\BuilderInterface;
use Ghostwriter\Container\Service\Provider\AbstractProvider;
use Ghostwriter\EventDispatcher\Interface\ListenerProviderInterface;
use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Container\Ghostwriter\Config\ScaffoldConfigurationExtension;
use Ghostwriter\Scaffold\Container\Ghostwriter\EventDispatcher\ListenerProviderExtension;
use Ghostwriter\Scaffold\Container\ScaffoldProvider;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldInterface;
use Ghostwriter\Scaffold\Scaffold;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\AbstractTestCase;

use function is_a;

#[CoversClass(ScaffoldProvider::class)]
final class ScaffoldProviderTest extends AbstractTestCase
{
    public function testExtendsAbstractProvider(): void
    {
        self::assertTrue(is_a(ScaffoldProvider::class, AbstractProvider::class, true));
    }

    public function testScaffoldProviderRegister(): void
    {
        $builder = $this->createMock(BuilderInterface::class);

        $builder->expects(self::exactly(2))
            ->method('alias')
            ->withParameterSetsInOrder(
                [ScaffoldInterface::class, Scaffold::class],
                [ScaffoldConfigurationInterface::class, ScaffoldConfiguration::class],
            );

        $builder->expects(self::once())
            ->method('bind')
            ->withParameterSetsInOrder([
                Scaffold::class,
                ConfigurationInterface::class,
                ScaffoldConfigurationInterface::class,
            ]);

        $builder->expects(self::exactly(2))
            ->method('extend')
            ->withParameterSetsInOrder(
                [ListenerProviderInterface::class, ListenerProviderExtension::class],
                [ScaffoldConfigurationInterface::class, ScaffoldConfigurationExtension::class],
            )
            ->seal();

        (new ScaffoldProvider())->register($builder);
    }
}

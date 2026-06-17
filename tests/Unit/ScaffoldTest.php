<?php

declare(strict_types=1);

namespace Tests\Unit;

use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldInterface;
use Ghostwriter\Scaffold\Scaffold;
use PHPUnit\Framework\Attributes\CoversClass;
use Throwable;

use function is_a;

#[CoversClass(Scaffold::class)]
final class ScaffoldTest extends AbstractTestCase
{
    public function testConstructorStoresInjectedConfiguration(): void
    {
        $configuration = $this->createMock(ScaffoldConfigurationInterface::class);

        $configuration->expects(self::never())->method('get')->seal();

        $scaffold = new Scaffold($configuration);

        self::assertSame($configuration, $scaffold->configuration());
    }

    public function testDefaultConfiguration(): void
    {
        $defaultConfiguration = [
            'default' => 'configuration',
        ];

        $configuration = $this->createMock(ScaffoldConfigurationInterface::class);

        $configuration->expects(self::once())
            ->method('toArray')
            ->willReturn($defaultConfiguration)
            ->seal();

        $scaffold = Scaffold::new($configuration);

        self::assertInstanceOf(ScaffoldConfigurationInterface::class, $scaffold->configuration());
        self::assertSame($defaultConfiguration, $scaffold->configuration()->toArray());
    }

    /** @throws Throwable */
    public function testImplementsScaffoldInterface(): void
    {
        self::assertTrue(is_a(Scaffold::class, ScaffoldInterface::class, true));
    }

    public function testNewCreatesDefaultConfigurationWhenNoneIsProvided(): void
    {
        $scaffold = Scaffold::new();

        self::assertInstanceOf(ScaffoldConfigurationInterface::class, $scaffold->configuration());
        self::assertInstanceOf(ScaffoldConfiguration::class, $scaffold->configuration());
        self::assertSame([], $scaffold->configuration()->toArray());
    }

    public function testNewUsesProvidedConfiguration(): void
    {
        $configuration = $this->createMock(ScaffoldConfigurationInterface::class);
        $configuration->expects(self::never())->method('get')->seal();

        $scaffold = Scaffold::new($configuration);

        self::assertSame($configuration, $scaffold->configuration());
    }
}

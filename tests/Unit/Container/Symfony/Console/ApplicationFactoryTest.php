<?php

declare(strict_types=1);

namespace Tests\Unit\Container\Symfony\Console;

use Composer\InstalledVersions;
use Ghostwriter\Container\Interface\ContainerInterface;
use Ghostwriter\Container\Interface\Service\FactoryInterface;
use Ghostwriter\Container\PsrContainer;
use Ghostwriter\Scaffold\Container\Symfony\Console\ApplicationFactory;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use ReflectionProperty;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

use Tests\Unit\AbstractTestCase;

use function is_a;

#[CoversClass(ApplicationFactory::class)]
final class ApplicationFactoryTest extends AbstractTestCase
{
    public function testImplementsFactoryInterface(): void
    {
        self::assertTrue(is_a(ApplicationFactory::class, FactoryInterface::class, true));
    }

    public function testInvokeReturnsConfiguredSymfonyApplication(): void
    {
        $command = new Command('app:run');

        $psrContainerDelegate = $this->createMock(ContainerInterface::class);
        $psrContainerDelegate->expects(self::exactly(2))
            ->method('has')
            ->with('command.service')
            ->willReturn(true);
        $psrContainerDelegate->expects(self::once())
            ->method('get')
            ->with('command.service')
            ->willReturn($command)
            ->seal();

        $configuration = $this->createMock(ScaffoldConfigurationInterface::class);
        $consoleConfiguration = $this->createMock(ScaffoldConfigurationInterface::class);

        $configuration->expects(self::once())
            ->method('wrap')
            ->with('ghostwriter.console')
            ->willReturn($consoleConfiguration)
            ->seal();

        $consoleConfiguration->expects(self::exactly(8))
            ->method('get')
            ->withParameterSetsInOrder(
                ['name', 'Scaffold Console'],
                ['package', 'ghostwriter/scaffold'],
                ['auto_exit', false],
                ['catch_errors', false],
                ['catch_exceptions', false],
                [
                    'commands', [
                        'app:run' => 'command.service',
                    ],
                ],
                ['default_command', false],
                ['single_command', false],
            )
            ->willReturnOnConsecutiveCalls(
                'Test Console',
                'ghostwriter/scaffold',
                true,
                true,
                false,
                [
                    'app:run' => 'command.service',
                ],
                'app:run',
                true,
            )
            ->seal();

        $container = $this->createMock(ContainerInterface::class);
        $container->expects(self::exactly(2))
            ->method('get')
            ->withParameterSetsInOrder([ScaffoldConfigurationInterface::class], [PsrContainer::class])
            ->willReturnOnConsecutiveCalls($configuration, new PsrContainer($psrContainerDelegate))
            ->seal();

        $application = (new ApplicationFactory())($container);

        self::assertInstanceOf(Application::class, $application);
        self::assertSame('Test Console', $application->getName());
        self::assertSame(InstalledVersions::getPrettyVersion('ghostwriter/scaffold'), $application->getVersion());
        self::assertTrue($application->isAutoExitEnabled());
        self::assertFalse($application->areExceptionsCaught());
        self::assertTrue($application->isSingleCommand());
        self::assertTrue($application->has('app:run'));
        self::assertSame($command, $application->find('app:run'));
        self::assertTrue($this->readBooleanProperty($application, 'catchErrors'));
        self::assertSame('app:run', $this->readStringProperty($application, 'defaultCommand'));
    }

    private function readBooleanProperty(object $object, string $property): bool
    {
        return $this->readProperty($object, $property);
    }

    private function readProperty(object $object, string $property): mixed
    {
        $reflectionProperty = new ReflectionProperty($object, $property);

        return $reflectionProperty->getValue($object);
    }

    private function readStringProperty(object $object, string $property): string
    {
        return $this->readProperty($object, $property);
    }
}

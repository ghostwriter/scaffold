<?php

declare(strict_types=1);

namespace Ghostwriter\Scaffold\Container\Ghostwriter\Config;

use Ghostwriter\Container\Interface\ContainerInterface;
use Ghostwriter\Container\Interface\Service\ExtensionInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Override;
use Throwable;

use const DIRECTORY_SEPARATOR;

use function assert;
use function dirname;
use function implode;
use function is_dir;

/**
 * @see ScaffoldConfigurationExtensionTest
 *
 * @implements ExtensionInterface<ScaffoldConfigurationInterface>
 */
final readonly class ScaffoldConfigurationExtension implements ExtensionInterface
{
    /**
     * @param ScaffoldConfigurationInterface $service
     *
     * @throws Throwable
     */
    #[Override]
    public function __invoke(ContainerInterface $container, object $service): void
    {
        assert($service instanceof ScaffoldConfigurationInterface);

        $configDirectory = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__, 4), 'config']);

        assert(is_dir($configDirectory), 'Expected configuration directory to exist at path: ' . $configDirectory);

        $service->mergeDirectory($configDirectory);
    }
}

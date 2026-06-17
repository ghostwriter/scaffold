<?php

declare(strict_types=1);

namespace Ghostwriter\Scaffold\Container;

use Ghostwriter\Config\Interface\ConfigurationInterface;
use Ghostwriter\Container\Interface\BuilderInterface;
use Ghostwriter\Container\Service\Provider\AbstractProvider;
use Ghostwriter\EventDispatcher\Interface\ListenerProviderInterface;
use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Container\Ghostwriter\Config\ScaffoldConfigurationExtension;
use Ghostwriter\Scaffold\Container\Ghostwriter\EventDispatcher\ListenerProviderExtension;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldInterface;
use Ghostwriter\Scaffold\Scaffold;
use Override;
use Throwable;

/**
 * @see ScaffoldProviderTest
 */
final class ScaffoldProvider extends AbstractProvider
{
    /** @throws Throwable */
    #[Override]
    public function register(BuilderInterface $builder): void
    {
        $builder->alias(ScaffoldInterface::class, Scaffold::class);
        $builder->alias(ScaffoldConfigurationInterface::class, ScaffoldConfiguration::class);

        $builder->bind(Scaffold::class, ConfigurationInterface::class, ScaffoldConfigurationInterface::class);

        $builder->extend(ListenerProviderInterface::class, ListenerProviderExtension::class);
        $builder->extend(ScaffoldConfigurationInterface::class, ScaffoldConfigurationExtension::class);
    }
}

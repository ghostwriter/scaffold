<?php

declare(strict_types=1);

use Ghostwriter\Config\Interface\ConfigurationInterface;
use Ghostwriter\Container\Interface\Service\ExtensionInterface;
use Ghostwriter\Container\Interface\Service\FactoryInterface;
use Ghostwriter\EventDispatcher\Interface\ListenerProviderInterface;
use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Container\Ghostwriter\Config\ScaffoldConfigurationExtension;
use Ghostwriter\Scaffold\Container\Ghostwriter\EventDispatcher\ListenerProviderExtension;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldInterface;
use Ghostwriter\Scaffold\Scaffold;

/**
 * @return array{
 *     'alias': array<class-string,class-string>,
 *     'extend': array<class-string,list<class-string<ExtensionInterface>>>,
 *     'factory': array<class-string,class-string<FactoryInterface>>
 * }
 */
return [
    'alias' => [
        ScaffoldInterface::class => Scaffold::class,
        ScaffoldConfigurationInterface::class => ScaffoldConfiguration::class,
    ],
    'extend' => [
        ConfigurationInterface::class => [ScaffoldConfigurationExtension::class],
        ListenerProviderInterface::class => [ListenerProviderExtension::class],
    ],
    'factory' => [],
];

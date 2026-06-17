<?php

declare(strict_types=1);

namespace Ghostwriter\Scaffold;

use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use Ghostwriter\Scaffold\Interface\ScaffoldInterface;

/** @see ScaffoldTest */
final class Scaffold implements ScaffoldInterface
{
    public function __construct(
        private ScaffoldConfigurationInterface $configuration
    ) {}

    public static function new(?ScaffoldConfigurationInterface $configuration = null): self
    {
        return new self($configuration ?? ScaffoldConfiguration::new());
    }

    public function configuration(): ScaffoldConfigurationInterface
    {
        return $this->configuration;
    }
}

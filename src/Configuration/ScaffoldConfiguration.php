<?php

declare(strict_types=1);

namespace Ghostwriter\Scaffold\Configuration;

use Ghostwriter\Config\AbstractConfiguration;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;

/**
 * @template T of (array<non-empty-string,T>|bool|float|int|null|string)
 *
 * @extends AbstractConfiguration<T>
 *
 * @see ScaffoldConfigurationTest
 */
final class ScaffoldConfiguration extends AbstractConfiguration implements ScaffoldConfigurationInterface {}

<?php

declare(strict_types=1);

namespace Tests\Unit\Configuration;

use Ghostwriter\Config\AbstractConfiguration;
use Ghostwriter\Scaffold\Configuration\ScaffoldConfiguration;
use Ghostwriter\Scaffold\Interface\ScaffoldConfigurationInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use Tests\Unit\AbstractTestCase;

use function is_a;

#[CoversClass(ScaffoldConfiguration::class)]
final class ScaffoldConfigurationTest extends AbstractTestCase
{
    public function testExtendsAbstractConfiguration(): void
    {
        self::assertTrue(is_a(ScaffoldConfiguration::class, AbstractConfiguration::class, true));
    }

    public function testImplementsScaffoldConfigurationInterface(): void
    {
        self::assertTrue(is_a(ScaffoldConfiguration::class, ScaffoldConfigurationInterface::class, true));
    }

    public function testSetStoresNestedConfigurationValues(): void
    {
        $configuration = ScaffoldConfiguration::new();

        $configuration->set('ghostwriter.scaffold.enabled', true);

        self::assertTrue($configuration->has('ghostwriter.scaffold.enabled'));
        self::assertTrue($configuration->get('ghostwriter.scaffold.enabled'));
        self::assertSame([
            'ghostwriter' => [
                'scaffold' => [
                    'enabled' => true,
                ],
            ],
        ], $configuration->toArray());
    }
}

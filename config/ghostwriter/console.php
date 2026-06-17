<?php

declare(strict_types=1);

use Symfony\Component\Console\Command\Command;

/**
 * @return array{
 *     name: string,
 *     package: string,
 *     auto_exit: bool,
 *     single_command: bool,
 *     default_command: string,
 *     catch_errors: bool,
 *     catch_exceptions: bool,
 *     commands: array<non-empty-string,class-string<Command>>
 * }
 */
return [
    'name' => 'Scaffold',
    'package' => 'ghostwriter/scaffold',
    'auto_exit'       => false,
    'single_command'       => false,
    'default_command'  => 'list',
    'catch_errors'     => true,
    'catch_exceptions' => true,
    'commands' => [
        // 'command:name' => FullyQualifiedClassName::class,
    ],
];

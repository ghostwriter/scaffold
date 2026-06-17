<?php

declare(strict_types=1);

namespace Ghostwriter\Scaffold\Exception;

use Ghostwriter\Scaffold\Interface\ExceptionInterface;
use LogicException;

final class ShouldNotHappenException extends LogicException implements ExceptionInterface {}

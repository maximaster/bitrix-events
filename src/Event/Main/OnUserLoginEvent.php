<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие после входа пользователя.
 *
 * @psalm-immutable
 */
class OnUserLoginEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public int $userId;
    public array $parameters;

    public function __construct(int $userId, array $parameters)
    {
        $this->userId = $userId;
        $this->parameters = $parameters;
    }
}

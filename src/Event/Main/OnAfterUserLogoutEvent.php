<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Webmozart\Assert\Assert;

/**
 * Событие после выхода пользователя.
 */
class OnAfterUserLogoutEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_USER_ID = 'USER_ID';
    public const SUCCESS = 'SUCCESS';

    public array $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Идентификатор пользователя который вышел.
     */
    public function userId(): int
    {
        $userId = (int) $this->parameters[self::PARAM_USER_ID];
        Assert::positiveInteger($userId, 'Событие не содержит корректного идентификатора пользователя.');

        return $userId;
    }

    public function hasUserId(): bool
    {
        $userId = (int) ($this->parameters[self::PARAM_USER_ID] ?? 0);

        return $userId > 0;
    }

    public function successful(): bool
    {
        return $this->parameters[self::SUCCESS] ?? false;
    }
}

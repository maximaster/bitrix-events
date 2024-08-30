<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Webmozart\Assert\Assert;

/**
 * Событие после попытки авторизации.
 */
class OnAfterUserLoginEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_USER_ID = 'USER_ID';
    public const PARAM_LOGIN = 'LOGIN';
    public const PARAM_PASSWORD = 'PASSWORD';
    public const PARAM_REMEMBER = 'REMEMBER';
    public const PARAM_PASSWORD_ORIGINAL = 'PASSWORD_ORIGINAL';
    public const PARAM_RESULT_MESSAGE = 'RESULT_MESSAGE';
    public const PARAM_MESSAGE = 'MESSAGE';
    public const PARAM_TYPE = 'TYPE';

    /**
     * @psalm-var array<'USER_ID'|'LOGIN'|'PASSWORD'|'REMEMBER'|'PASSWORD_ORIGINAL',mixed>
     */
    public array $parameters;

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function isSuccessAuthorized(): bool
    {
        return $this->hasUserId();
    }

    public function hasUserId(): bool
    {
        $userId = (int) ($this->parameters[self::PARAM_USER_ID] ?? 0);

        return $userId > 0;
    }

    public function userId(): int
    {
        $userId = (int) ($this->parameters[self::PARAM_USER_ID] ?? 0);

        Assert::positiveInteger($userId, 'Событие не содержит корректного идентификатора пользователя.');

        return $userId;
    }
}

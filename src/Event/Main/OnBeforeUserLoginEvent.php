<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use CApplicationException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Система готова авторизовать пользователя.
 */
class OnBeforeUserLoginEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<'LOGIN'|'PASSWORD'|'REMEMBER'|'PASSWORD_ORIGINAL',string>
     */
    public array $params;

    /** @var bool была ли отменена авторизация */
    private bool $cancel = false;

    /**
     * @psalm-param array<'LOGIN'|'PASSWORD'|'REMEMBER'|'PASSWORD_ORIGINAL',string> $params
     */
    public function __construct(array &$params)
    {
        $this->params = $params;
    }

    /**
     * @param string|CApplicationException $message
     *
     * @SuppressWarnings(PHPMD.CamelCaseVariableName) why:dependency
     */
    public function cancel($message): void
    {
        $this->cancel = true;

        global $APPLICATION;
        $APPLICATION->ThrowException($message);
    }

    public function product(): bool
    {
        return $this->cancel === false;
    }
}

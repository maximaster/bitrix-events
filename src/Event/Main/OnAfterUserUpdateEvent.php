<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Main\UserTable;

/**
 * Вызывается после обновления данных пользователя.
 */
class OnAfterUserUpdateEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_ID = UserTable::ID;
    public const PARAM_LAST_NAME = UserTable::LAST_NAME;
    public const PARAM_NAME = UserTable::NAME;
    public const PARAM_SECOND_NAME = UserTable::SECOND_NAME;

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array &$parameters)
    {
        $this->parameters = ParameterBag::fromArrayReference($parameters);
    }

    /**
     * @throws BitrixEventsException
     *
     * @psalm-return int<1, max>
     */
    public function userId(): int
    {
        return $this->parameters->getIntId(self::PARAM_ID);
    }
}

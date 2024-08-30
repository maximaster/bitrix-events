<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\CancellableEvent;
use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Webmozart\Assert\Assert;

/**
 * Событие после обновления пользователя.
 *
 * @psalm-immutable
 */
class OnBeforeUserUpdateEvent implements ProductiveEvent, CancellableEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    private const PARAM_DEPARTMENTS = 'UF_DEPARTMENT';
    private const PARAM_ID = 'ID';

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array &$parameters)
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $this->parameters = ParameterBag::fromArrayReference($parameters);
    }

    /**
     * @throws BitrixEventsException
     *
     * @psalm-return int<1, max>
     */
    public function id(): int
    {
        return $this->parameters->getIntId(self::PARAM_ID);
    }

    /**
     * Существуют ли подразделения в параметрах события.
     */
    public function hasDepartments(): bool
    {
        return $this->parameters->has(self::PARAM_DEPARTMENTS);
    }

    /**
     * Возвращает идентификаторы подразделений пользователя.
     *
     * @return int[]
     *
     * @throws BitrixEventsException
     *
     * @psalm-return list<int<1, max>>
     */
    public function getDepartments(): array
    {
        return $this->parameters->getIdList(self::PARAM_DEPARTMENTS);
    }
}

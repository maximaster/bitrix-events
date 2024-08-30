<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Orion\Process\UserManagement\Infrastructure\Role\Table\GroupTable;
use Webmozart\Assert\Assert;

/**
 * Событие, вызывающееся перед добавлением группы пользователей.
 */
class OnBeforeGroupAddEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    public const PARAM_STRING_ID = GroupTable::STRING_ID;

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array &$parameters)
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $this->parameters = ParameterBag::fromArrayReference($parameters);
    }
}

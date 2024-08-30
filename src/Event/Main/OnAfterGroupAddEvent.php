<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Main\GroupTable;
use Webmozart\Assert\Assert;

class OnAfterGroupAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_ID = GroupTable::ID;
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

<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Iblock\ElementTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается перед добавленим элемента инфоблока.
 */
class OnBeforeIBlockElementAddEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    public const PARAM_IBLOCK_ID = ElementTable::IBLOCK_ID;
    public const PARAM_WF_PARENT_ELEMENT_ID = ElementTable::WF_PARENT_ELEMENT_ID;
    public const PARAM_XML_ID = ElementTable::XML_ID;
    public const PARAM_NAME = ElementTable::NAME;
    public const PARAM_RIGHTS = 'RIGHTS';

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
    public function iblockId(): int
    {
        return $this->parameters->getIntId(self::PARAM_IBLOCK_ID);
    }
}

<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Iblock\ElementTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается после удаления элемента инфоблока.
 *
 * @psalm-immutable
 */
class OnAfterIBlockElementDeleteEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_WF_PARENT_ELEMENT_ID = ElementTable::WF_PARENT_ELEMENT_ID;
    public const PARAM_IBLOCK_ID = ElementTable::IBLOCK_ID;
    public const PARAM_EXTERNAL_ID = 'EXTERNAL_ID';

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array $parameters)
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $this->parameters = ParameterBag::fromArray($parameters);
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

    /**
     * @return int|string|float|null
     *
     * @throws BitrixEventsException
     */
    public function xmlId()
    {
        $xmlId = $this->parameters->get(self::PARAM_EXTERNAL_ID);

        if ($xmlId !== null && is_scalar($xmlId) === false || is_bool($xmlId)) {
            throw new BitrixEventsException('Неправильный тип внешнего кода элемента информационного блока.');
        }

        return $xmlId;
    }
}

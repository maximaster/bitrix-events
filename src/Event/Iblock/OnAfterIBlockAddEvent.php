<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Iblock\IBlockTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается после добавления информационного блока.
 */
class OnAfterIBlockAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_RESULT = 'RESULT';
    public const PARAM_ID = IBlockTable::ID;
    public const PARAM_XML_ID = IBlockTable::XML_ID;
    public const PARAM_IBLOCK_TYPE_ID = IBlockTable::IBLOCK_TYPE_ID;

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
     * Успешна ли операция добавления инфоблока.
     *
     * @throws BitrixEventsException
     */
    public function successAdded(): bool
    {
        return $this->parameters->get(self::PARAM_RESULT) !== false;
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
     * @return int|string|float|null
     *
     * @throws BitrixEventsException
     */
    public function xmlId()
    {
        $xmlId = $this->parameters->get(self::PARAM_XML_ID);

        if ($xmlId !== null && is_scalar($xmlId) === false || is_bool($xmlId)) {
            throw new BitrixEventsException('Неправильный тип внешнего кода информационного блока.');
        }

        return $xmlId;
    }

    /**
     * @throws BitrixEventsException
     *
     * @psalm-return non-empty-string
     */
    public function iblockType(): string
    {
        return $this->parameters->getNonEmptyString(self::PARAM_IBLOCK_TYPE_ID);
    }
}

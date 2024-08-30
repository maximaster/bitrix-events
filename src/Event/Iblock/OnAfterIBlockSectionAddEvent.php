<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Iblock\SectionTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается после добавления раздела инфоблока.
 */
class OnAfterIBlockSectionAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_RESULT = 'RESULT';
    public const PARAM_ID = SectionTable::ID;
    public const PARAM_IBLOCK_ID = SectionTable::IBLOCK_ID;
    public const PARAM_XML_ID = SectionTable::XML_ID;

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
     * Успешно ли прошла операция добавления раздела инфоблока.
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
            throw new BitrixEventsException('Неправильный тип внешнего кода раздела информационного блока.');
        }

        return $xmlId;
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

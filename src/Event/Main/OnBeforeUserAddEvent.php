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
 * Вызывается перед созданием нового пользователя.
 *
 * @psalm-type XmlIdType = float|int|string|null
 */
class OnBeforeUserAddEvent implements ProductiveEvent, CancellableEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    private const PARAM_GROUPS = 'GROUP_ID';
    private const PARAM_DEPARTMENTS = 'UF_DEPARTMENT';
    private const PARAM_XML_ID = 'XML_ID';

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
     * Указан ли внешний код пользователя.
     */
    public function hasXmlId(): bool
    {
        return $this->parameters->has(self::PARAM_XML_ID);
    }

    /**
     * Возвращает внешний код пользователя.
     *
     * @throws BitrixEventsException
     *
     * @psalm-return XmlIdType
     */
    public function xmlId()
    {
        return self::itsCorrectXmlId($this->parameters->get(self::PARAM_XML_ID));
    }

    /**
     * Устанавливает внешний код пользователя.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param XmlIdType $xmlId
     */
    public function setXmlId($xmlId): void
    {
        $this->parameters->set(self::PARAM_XML_ID, self::itsCorrectXmlId($xmlId));
    }

    /**
     * Возвращает корректный внешний код пользователя.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param mixed $xmlId
     * @psalm-return XmlIdType
     */
    private static function itsCorrectXmlId($xmlId)
    {
        if ($xmlId !== null && is_string($xmlId) === false && is_numeric($xmlId) === false) {
            throw new BitrixEventsException('Неправильный тип внешнего кода пользователя.');
        }

        return $xmlId;
    }

    /**
     * Существуют ли подразделения в параметрах события.
     */
    public function hasDepartments(): bool
    {
        return $this->parameters->has(self::PARAM_DEPARTMENTS);
    }

    /**
     * Существуют ли группы в параметрах события.
     */
    public function hasGroups(): bool
    {
        return $this->parameters->has(self::PARAM_GROUPS);
    }

    /**
     * Возвращает идентификаторы групп пользователей.
     *
     * @return int[]
     *
     * @throws BitrixEventsException
     *
     * @psalm-return list<int<1, max>>
     */
    public function getGroups(): array
    {
        $groupIds = array_filter(array_column($this->parameters->getArray(self::PARAM_GROUPS), self::PARAM_GROUPS));

        return array_map(function ($groupId) { return intval($groupId); }, $groupIds);
    }

    /**
     * Устанавливает группы пользователя.
     *
     * @psalm-param list<int<1, max>> $ids
     */
    public function setGroups(array $ids): void
    {
        Assert::isList($ids);
        Assert::allPositiveInteger($ids);

        $this->parameters->set(self::PARAM_GROUPS, $ids);
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
        $depertmentIds = array_filter($this->parameters->getArray(self::PARAM_DEPARTMENTS));

        return array_map(function ($departmentId) { return intval($departmentId); }, $depertmentIds);
    }

    /**
     * Устанавливает подразделения пользователя.
     *
     * @param int[] $ids
     *
     * @psalm-param list<int<1, max>> $ids
     */
    public function setDepartments(array $ids): void
    {
        Assert::isList($ids);
        Assert::allPositiveInteger($ids);

        $this->parameters->set(self::PARAM_DEPARTMENTS, $ids);
    }
}

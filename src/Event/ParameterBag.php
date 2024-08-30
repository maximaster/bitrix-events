<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event;

use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Webmozart\Assert\Assert;

/**
 * Хранилище параметров событий.
 *
 * @psalm-type ParameterName non-empty-string
 * @psalm-type ParameterValue mixed
 * @psalm-type ArrayParameters array<ParameterName, ParameterValue>
 */
class ParameterBag
{
    /**
     * Параметры события.
     *
     * @psalm-var ArrayParameters
     */
    private array $parameters;

    final private function __construct()
    {
    }

    /**
     * Создает хранилище, изменяющее параметры, из которых оно создано.
     *
     * @psalm-param ArrayParameters $parameters
     */
    public static function fromArrayReference(array &$parameters): self
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $bag = new self();
        $bag->parameters = &$parameters;

        return $bag;
    }

    /**
     * Создает хранилище, не изменяющее параметры, из которых оно создано.
     *
     * @psalm-param ArrayParameters $parameters
     */
    public static function fromArray(array $parameters): self
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $bag = new self();
        $bag->parameters = $parameters;

        return $bag;
    }

    /**
     * Установить параметр пользователя.
     *
     * @psalm-param ParameterName $parameter
     * @psalm-param ParameterValue $value
     */
    public function set(string $parameter, $value): void
    {
        Assert::stringNotEmpty($parameter);

        $this->parameters[$parameter] = $value;
    }

    /**
     * Установить несколько параметров пользователя.
     *
     * @psalm-param ArrayParameters $parameters
     */
    public function setMany(array $parameters): void
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        foreach ($parameters as $parameter => $value) {
            $this->parameters[$parameter] = $value;
        }
    }

    /**
     * Проверяет, имеются ли в событии все указанные параметры.
     *
     * @psalm-param list<ParameterName> $parameterNames
     */
    public function hasAllNames(array $parameterNames): bool
    {
        Assert::isList($parameterNames);
        Assert::allStringNotEmpty($parameterNames);

        return count(array_intersect(array_keys($this->parameters), $parameterNames)) === count($parameterNames);
    }

    /**
     * Проверяет, имеется ли в событии хотя бы один из указанных параметров.
     *
     * @psalm-param list<ParameterName> $parameterNames
     */
    public function hasAnyName(array $parameterNames): bool
    {
        Assert::isList($parameterNames);
        Assert::allStringNotEmpty($parameterNames);

        return count(array_intersect(array_keys($this->parameters), $parameterNames)) > 0;
    }

    /**
     * Проверяет, существует ли параметр.
     *
     * @psalm-param ParameterName $parameterName
     */
    public function has(string $parameterName): bool
    {
        Assert::stringNotEmpty($parameterName);

        return array_key_exists($parameterName, $this->parameters);
    }

    /**
     * Получает целочисленное значение параметра.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param ParameterName $parameterName
     */
    public function getInt(string $parameterName): int
    {
        Assert::stringNotEmpty($parameterName);

        $this->assertHasName($parameterName);

        $value = $this->get($parameterName);
        if (is_numeric($value) === false) {
            throw new BitrixEventsException(
                sprintf('В параметре [%s] ожидалось число, получено [%s].', $parameterName, get_debug_type($value))
            );
        }

        return (int) $value;
    }

    /**
     * Получает целочисленный идентификатор.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param ParameterName $parameterName
     * @psalm-return int<1, max>
     */
    public function getIntId(string $parameterName): int
    {
        Assert::stringNotEmpty($parameterName);

        $this->assertHasName($parameterName);

        $value = $this->getInt($parameterName);
        if ($value <= 0) {
            throw new BitrixEventsException(
                sprintf('В параметре [%s] ожидалось положительное число, получено [%d].', $parameterName, $value)
            );
        }

        return $value;
    }

    /**
     * Получает строковое значение параметра.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param non-empty-string $parameterName
     */
    public function getString(string $parameterName): string
    {
        Assert::stringNotEmpty($parameterName);

        $this->assertHasName($parameterName);

        $value = $this->get($parameterName);
        if (is_string($value) === false) {
            throw new BitrixEventsException(
                sprintf('В параметре [%s] ожидалась строка, получено [%s].', $parameterName, get_debug_type($value))
            );
        }

        return $value;
    }

    /**
     * Получает не пустую строку из параметра.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param non-empty-string $parameterName
     */
    public function getNonEmptyString(string $parameterName): string
    {
        $value = $this->getString($parameterName);
        if ($value === '') {
            throw new BitrixEventsException(sprintf('Ожидалось, что в параметре %s будет не пустая строка.', $parameterName));
        }

        return $value;
    }

    /**
     * Возвращает значение определённого параметра.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param ParameterName $parameter
     * @psalm-return ParameterValue
     */
    public function get(string $parameter)
    {
        Assert::stringNotEmpty($parameter);

        $this->assertHasName($parameter);

        return $this->parameters[$parameter];
    }

    /**
     * Возвращает все параметры.
     *
     * @psalm-return ArrayParameters
     */
    public function toArray(): array
    {
        return $this->parameters;
    }

    /**
     * Проверяет наличие указанного параметра равного нужному значению.
     *
     * @psalm-param ParameterName $parameterName
     * @psalm-param ParameterValue $value
     */
    public function hasParameterEqualTo(string $parameterName, $value): bool
    {
        Assert::stringNotEmpty($parameterName);

        return ($this->parameters[$parameterName] ?? null) === $value;
    }

    /**
     * @throws BitrixEventsException
     *
     * @psalm-param non-empty-string $parameterName
     * @psalm-return scalar|null
     */
    public function getNullableScalar(string $parameterName)
    {
        Assert::stringNotEmpty($parameterName);
        $this->assertHasName($parameterName);
        $isNullableScalar = is_null($this->parameters[$parameterName]) || is_scalar($this->parameters[$parameterName]);
        if ($isNullableScalar === false) {
            throw new BitrixEventsException(sprintf('Ожидалось, что в параметре %s будет скаляр или NULL.', $parameterName));
        }

        return $this->parameters[$parameterName];
    }

    /**
     * Получает массив значений параметра.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param non-empty-string $parameterName
     *
     * @psalm-return array<array-key, mixed>
     */
    public function getArray(string $parameterName): array
    {
        Assert::stringNotEmpty($parameterName);

        $this->assertHasName($parameterName);
        if (is_array($this->parameters[$parameterName]) === false) {
            throw new BitrixEventsException(sprintf('Ожидалось, что в параметре %s будет массив.', $parameterName));
        }

        return $this->parameters[$parameterName];
    }

    /**
     * @psalm-return list<int<1, max>>
     */
    public function getIdList(string $parameterName): array
    {
        $list = array_values($this->parameters->getArray($parameterName));
        $filteredList = array_filter(
            $list,
            function ($item) { return is_numeric($item) && intval($item) > 0; }
        );

        if ($filteredList !== $list) {
            throw new BitrixEventsException(
                sprintf(
                    'Ожидалось, что в параметре %s будут находиться положительные числовые значения.',
                    $parameterName
                )
            );
        }

        return array_map('intval', $list);
    }

    /**
     * Утверждает, что параметр есть в списке параметров.
     *
     * @throws BitrixEventsException
     *
     * @psalm-param ParameterName $parameterName
     */
    private function assertHasName(string $parameterName): void
    {
        Assert::stringNotEmpty($parameterName);

        if ($this->has($parameterName) === false) {
            throw new BitrixEventsException(sprintf('Не удалось найти параметр [%s].', $parameterName));
        }
    }
}

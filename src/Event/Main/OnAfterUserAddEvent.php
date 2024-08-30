<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use RuntimeException;

/**
 * Пользователь добавлен в БД.
 */
class OnAfterUserAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const PARAM_USER_ID = 'ID';
    public const PARAM_XML_ID = 'XML_ID';

    /**
     * @psalm-var array<string,mixed>
     */
    public array $parameters;

    /**
     * @psalm-param array<string,mixed>
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function successful(): bool
    {
        return ((int) $this->parameters[self::PARAM_USER_ID]) > 0;
    }

    /**
     * Валидирует процесс создакния пользователя по входным параметрам события.
     *
     * @throws RuntimeException
     */
    public function validateUserAddingResult(): void
    {
        if (((int) $this->parameters[self::PARAM_USER_ID]) > 0) {
            return;
        }

        throw new RuntimeException(
            isset($this->parameters['RESULT_MESSAGE']) && strlen($this->parameters['RESULT_MESSAGE']) > 0
            ? $this->parameters['RESULT_MESSAGE']
            : 'Неизвестная ошибка создания пользователя.'
        );
    }

    /**
     * Возвращает XML_ID пользователя.
     */
    public function xmlId(): ?string
    {
        return $this->parameters[self::PARAM_XML_ID];
    }
}

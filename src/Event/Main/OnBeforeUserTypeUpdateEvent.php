<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use CApplicationException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Система готова обновить пользовательское поле.
 */
class OnBeforeUserTypeUpdateEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<string, mixed>
     */
    public array $fields;

    /** @var bool было ли отменено обновление */
    private bool $cancel = false;

    /**
     * @psalm-param array<string, mixed> $fields
     */
    public function __construct(array &$fields)
    {
        $this->fields = &$fields;
    }

    /**
     * @param string|CApplicationException $message
     *
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function cancel($message): void
    {
        $this->cancel = true;

        global $APPLICATION;
        $APPLICATION->ThrowException($message);
    }

    public function product(): bool
    {
        return $this->cancel === false;
    }
}

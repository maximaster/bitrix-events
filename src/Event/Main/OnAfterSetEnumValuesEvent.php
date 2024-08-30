<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEvents\Event\WrappedEvent;

/**
 * Событие после установки вариантов значений для пользовательского поля.
 */
class OnAfterSetEnumValuesEvent extends WrappedEvent
{
    public function geFieldId(): int
    {
        return (int) $this->unwrap()->getParameter(0);
    }

    /**
     * @psalm-var array<int|string, mixed>
     */
    public function getOriginalValues(): array
    {
        return $this->unwrap()->getParameter(1);
    }

    /**
     * @psalm-var array<int|string, mixed>
     */
    public function getPreviousValues(): array
    {
        return $this->unwrap()->getParameter(2);
    }
}

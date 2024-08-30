<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Maximaster\BitrixEvents\Event\WrappedEvent;

/**
 * Хранилище создано.
 */
class StorageOnAfterAddEvent extends WrappedEvent
{
    public function unwrapFields(): array
    {
        return $this->unwrap()->getParameter('fields');
    }
}

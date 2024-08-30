<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Maximaster\BitrixEvents\Event\WrappedEvent;

/**
 * Хранилище диска готово к созданию.
 */
class StorageOnBeforeAddEvent extends WrappedEvent
{
    public const PARAMETER_FIELDS = 'fields';
}

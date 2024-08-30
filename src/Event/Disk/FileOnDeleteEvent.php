<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Maximaster\BitrixEvents\Event\WrappedOrmEvent;

/**
 * Файл диска удалён.
 */
class FileOnDeleteEvent extends WrappedOrmEvent
{
}

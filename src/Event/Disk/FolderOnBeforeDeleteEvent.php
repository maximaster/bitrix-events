<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Maximaster\BitrixEvents\Event\WrappedOrmEvent;

/**
 * Папка диска готова к удалению.
 */
class FolderOnBeforeDeleteEvent extends WrappedOrmEvent
{
}

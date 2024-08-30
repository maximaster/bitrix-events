<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Maximaster\BitrixEvents\Event\WrappedEvent;
use Maximaster\BitrixTableClasses\Table\Disk\ObjectTable;

/**
 * Событие, вызывающееся после удаления файла.
 */
class OnAfterDeleteFileEvent extends WrappedEvent
{
    /**
     * Идентификатор удаляемого файла.
     */
    public function fileId(): int
    {
        return (int) $this->unwrap()->getParameter(0);
    }

    /**
     * Идентификатор удаляющего пользователя.
     */
    public function deletedBy(): int
    {
        return $this->unwrap()->getParameter(1);
    }

    /**
     * Идентификатор диска, на котором находился удаленный файл.
     */
    public function storageId(): int
    {
        return (int) $this->unwrap()->getParameter(2)[ObjectTable::STORAGE_ID];
    }
}

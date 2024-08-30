<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Disk;

use Bitrix\Disk\BaseObject;
use Maximaster\BitrixEvents\Event\WrappedEvent;

/**
 * Событие, оповещающее об удалении объекта диска.
 */
class OnAfterMarkDeletedObjectEvent extends WrappedEvent
{
    /**
     * Объект диска.
     */
    public function object(): BaseObject
    {
        return $this->unwrap()->getParameter(0);
    }

    /**
     * Идентификатор пользователя, который производит удаление.
     */
    public function deletedBy(): int
    {
        return $this->unwrap()->getParameter(1);
    }

    /**
     * Статус удаления объекта.
     */
    public function deletedType(): int
    {
        return $this->unwrap()->getParameter(2);
    }
}

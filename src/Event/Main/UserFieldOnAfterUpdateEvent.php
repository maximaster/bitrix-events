<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEvents\Event\WrappedEvent;

/**
 * Пользовательское поле обновлено.
 */
class UserFieldOnAfterUpdateEvent extends WrappedEvent
{
    public function unwrapFields(): array
    {
        return $this->unwrap()->getParameter('fields');
    }
}

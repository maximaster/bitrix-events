<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event;

use Bitrix\Main\Event as BitrixEvent;
use Maximaster\BitrixEventDispatcher\Contract\Event;

/**
 * Обёртка над Битриксовым событием-объектом.
 *
 * @SuppressWarnings(PHPMD.NumberOfChildren) why:intended
 */
abstract class WrappedEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public BitrixEvent $event;

    public function __construct(BitrixEvent $event)
    {
        $this->event = $event;
    }

    public function unwrap(): BitrixEvent
    {
        return $this->event;
    }
}

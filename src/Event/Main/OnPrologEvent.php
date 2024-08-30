<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие начала отрисовки визуальной части пролога сайта.
 */
class OnPrologEvent implements Event
{
    use AutodetectedEventMetaTrait;
}

<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие выполняемой части пролога сайта.
 */
class OnBeforePrologEvent implements Event
{
    use AutodetectedEventMetaTrait;
}

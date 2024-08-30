<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие в начале выполняемой части пролога сайта, после подключения всех
 * библиотек и отработки агентов.
 */
class OnPageStartEvent implements Event
{
    use AutodetectedEventMetaTrait;
}

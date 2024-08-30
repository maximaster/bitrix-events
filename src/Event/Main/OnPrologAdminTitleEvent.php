<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие отрисовки заголовка страницы админки.
 *
 * @psalm-immutable
 */
class OnPrologAdminTitleEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public string $page;
    public $id;

    public function __construct(string $page, $id = null)
    {
        $this->page = $page;
        $this->id = $id;
    }
}

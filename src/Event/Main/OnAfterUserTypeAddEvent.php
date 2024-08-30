<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие после добавления пользовательского поля.
 */
class OnAfterUserTypeAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<string, mixed>
     */
    public array $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }
}

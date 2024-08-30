<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие после удаления пользовательского поля.
 */
class OnAfterUserTypeDeleteEvent implements Event
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<string, mixed>
     */
    public array $fieldParams;

    public int $id;

    public function __construct(array $fieldParams, int $id)
    {
        $this->fieldParams = $fieldParams;
        $this->id = $id;
    }
}

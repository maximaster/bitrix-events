<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие при построении списка пользовательских полей.
 */
class OnUserTypeBuildListEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<string,mixed>
     */
    private array $userFieldType;

    public function set(array $userFieldType): void
    {
        $this->userFieldType = $userFieldType;
    }

    public function product(): array
    {
        return $this->userFieldType;
    }
}

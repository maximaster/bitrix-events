<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * Событие построения контекстного меню.
 */
class OnAdminContextMenuShowEvent implements Event
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var list<array<non-empty-string, mixed>>
     */
    public array $items;

    /**
     * @psalm-var list<array<non-empty-string, mixed>>
     */
    public array $additinalItems;

    /**
     * @psalm-param list<array<non-empty-string, mixed>> $items
     * @psalm-param list<array<non-empty-string, mixed>> $additinalItems
     */
    public function __construct(array &$items, array &$additinalItems)
    {
        $this->items = &$items;
        $this->additinalItems = &$additinalItems;
    }

    public function appendItem(string $text, string $link, ?string $icon = null, ?string $title = null): void
    {
        $this->items[] = array_change_key_case(compact('text', 'title', 'link', 'icon'), CASE_UPPER);
    }
}

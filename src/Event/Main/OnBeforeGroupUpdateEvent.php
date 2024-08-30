<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;

/**
 * Событие, вызывающееся перед редактированием группы пользователей.
 */
class OnBeforeGroupUpdateEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    /**
     * @psalm-var array{
     *                  'ID': positive-int,
     *                  'TIMESTAMP_X'?: non-empty-string,
     *                  'ACTIVE'?: 'Y'|'N',
     *                  'NAME'?: non-empty-string,
     *                  'DESCRIPTION'?: string,
     *                  'C_SORT'?: int,
     *                  'STRING_ID'?: string
     *              }
     */
    public array $parameters;

    public int $id;

    /**
     * @psalm-param array{
     *                  'ID': positive-int,
     *                  'TIMESTAMP_X'?: non-empty-string,
     *                  'ACTIVE'?: 'Y'|'N',
     *                  'NAME'?: non-empty-string,
     *                  'DESCRIPTION'?: string,
     *                  'C_SORT'?: int,
     *                  'STRING_ID'?: string
     *              } $parameters
     */
    public function __construct(int $id, array &$parameters)
    {
        $this->id = $id;
        $this->parameters = &$parameters;
    }
}

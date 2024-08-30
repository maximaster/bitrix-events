<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Main;

use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;

/**
 * Пользователь готов к удалению из базы данных.
 */
class OnBeforeUserDeleteEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    /**
     * @psalm-var int<1, max>
     *
     * @psalm-readonly
     */
    public int $id;

    /**
     * @psalm-param int<1, max> $id
     */
    public function __construct(int $id)
    {
        if ($id <= 0) {
            throw new BitrixEventsException(
                sprintf(
                    'Ожидалось, что идентификатор пользователя в событии %s будет положительным числом, получено: %s.',
                    self::class,
                    var_export($id, true)
                )
            );
        }

        $this->id = $id;
    }
}

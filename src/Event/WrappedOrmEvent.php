<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event;

use Bitrix\Main\ORM\Event as OrmEvent;
use Maximaster\BitrixEventDispatcher\Contract\Event;
use RuntimeException;

abstract class WrappedOrmEvent implements Event
{
    use AutodetectedEventMetaTrait;

    private OrmEvent $event;

    public function __construct(OrmEvent $event)
    {
        $this->event = $event;
    }

    public function unwrap(): OrmEvent
    {
        return $this->event;
    }

    /**
     * Возвращает идентификатор из композитного ключа в настройках.
     *
     * @psalm-return int<1, max>
     */
    public function intIdParameter(string $parameterName = 'id'): int
    {
        $id = $this->unwrap()->getParameter($parameterName)['ID'] ?? null;
        if ($id === null || $id <= 0) {
            throw new RuntimeException('Ожидалось, что в параметре id будет указан первичный ключ определённого формата с положительным числом.');
        }

        return $id;
    }
}

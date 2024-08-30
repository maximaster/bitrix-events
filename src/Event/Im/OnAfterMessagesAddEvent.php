<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Im;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;

/**
 * TODO Разработать методы, необходимые для получения информации
 *  о постановке/снятии Like-ов чтобы не использовать ассоциативные
 *  массивы в обработчиках события.
 */
class OnAfterMessagesAddEvent implements Event
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var array<string, mixed>
     */
    public array $params;

    public int $id;

    /**
     * @psalm-param array<string, mixed> $fields
     */
    public function __construct(int $id, array $fields)
    {
        $this->params = $fields;
        $this->id = $id;
    }
}

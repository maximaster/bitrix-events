<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Im;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use RuntimeException;

/**
 * Событие установки или удаления лайка с сообщения.
 */
class OnAfterMessagesLikeEvent implements Event
{
    use AutodetectedEventMetaTrait;

    public const ACTION = 'ACTION';
    public const MESSAGE = 'MESSAGE';
    public const MESSAGE_ID = 'ID';

    /**
     * @psalm-var array<string, mixed>
     */
    public array $params;

    /**
     * @psalm-param array<string, mixed> $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * @psalm-return 'plus'|'minus'
     */
    public function action(): string
    {
        return $this->params[self::ACTION];
    }

    /**
     * Сообщение чата которому поставили или убрали лайк.
     */
    public function messageId(): int
    {
        if (
            array_key_exists(self::MESSAGE, $this->params) === false
            || array_key_exists(self::MESSAGE_ID, $this->params[self::MESSAGE]) === false
            || is_numeric($this->params[self::MESSAGE][self::MESSAGE_ID]) === false
        ) {
            throw new RuntimeException('Не удалось найти идентификатор сообщения в параметрах события.');
        }

        return (int) $this->params[self::MESSAGE][self::MESSAGE_ID];
    }
}

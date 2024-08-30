<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Im;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Webmozart\Assert\Assert;

class OnBeforeChatMessageAddEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    private const CHAT_ID_KEY = 'CHAT_ID';
    private const MESSAGE_FROM_USER_ID = 'FROM_USER_ID';

    /** @psalm-var array<string, mixed>*/
    public array $message;

    /** @psalm-var array<string, mixed> */
    public array $chat;

    /**
     * @psalm-param array<string, mixed> $message
     * @psalm-param array<string, mixed> $chat
     */
    public function __construct(array $message, array $chat)
    {
        // phpcs:ignore Generic.Files.LineLength.TooLong
        Assert::keyExists($chat, self::CHAT_ID_KEY, 'Ожидалось наличие идентификатора чата в событии добавления сообщения.');
        Assert::integerish($chat[self::CHAT_ID_KEY], 'Ожидалось число в качестве идентификатора чата. Получено %s');
        $chatId = (int) $chat[self::CHAT_ID_KEY];
        Assert::positiveInteger($chatId, 'Ожидалось положительное число в качестве идентификатора чата. Получено %s');

        // Приводим тип данных, чтобы не заниматься этим потом постоянно.
        $chat[self::CHAT_ID_KEY] = $chatId;

        $this->message = $message;
        $this->chat = $chat;
    }

    public function product(): ?array
    {
        return $this->cancelMessage === null ? null : [
            'result' => false,
            'reason' => $this->cancelMessage,
        ];
    }

    /**
     * @psalm-return positive-int
     */
    public function chatId(): int
    {
        return $this->chat[self::CHAT_ID_KEY];
    }

    /**
     * Сообщение отправлено системой.
     */
    public function isSystem(): bool
    {
        return ($this->message[self::MESSAGE_FROM_USER_ID] ?? false) === 0;
    }
}

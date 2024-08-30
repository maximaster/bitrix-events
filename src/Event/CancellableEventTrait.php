<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event;

use CApplicationException;

/**
 * Событие, которое можно отменить (обычно OnBefore-события).
 */
trait CancellableEventTrait
{
    public bool $canceled = false;
    public ?string $cancelMessage = null;

    /**
     * @param string|CApplicationException $message
     *
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function cancel($message): void
    {
        $this->canceled = true;
        $this->cancelMessage = $message instanceof CApplicationException ? $message->GetString() : $message;

        global $APPLICATION;
        $APPLICATION->ThrowException($message);
    }

    /**
     * {@inheritDoc}
     */
    public function product(): bool
    {
        return $this->canceled === false;
    }
}

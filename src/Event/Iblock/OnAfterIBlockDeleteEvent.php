<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Event;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Webmozart\Assert\Assert;

/**
 * Вызывается после удаления инфоблока.
 *
 * @psalm-immutable
 */
class OnAfterIBlockDeleteEvent implements Event
{
    use AutodetectedEventMetaTrait;

    /**
     * @psalm-var int<1, max>
     */
    public int $id;

    /**
     * @psalm-param int<1, max> $id
     */
    public function __construct(int $id)
    {
        Assert::positiveInteger($id);

        $this->id = $id;
    }
}

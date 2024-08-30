<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Webmozart\Assert\Assert;

/**
 * Вызывается перед удалением раздела инфоблока.
 */
class OnBeforeIBlockSectionDeleteEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    /**
     * @psalm-var positive-int
     *
     * @psalm-readonly
     */
    public int $id;

    /**
     * @psalm-param positive-int $id
     */
    public function __construct(int $id)
    {
        Assert::positiveInteger($id);

        $this->id = $id;
    }
}

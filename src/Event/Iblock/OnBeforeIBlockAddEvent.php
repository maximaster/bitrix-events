<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Iblock;

use Maximaster\BitrixEventDispatcher\Contract\Exception\Exception as BitrixEventsException;
use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Iblock\IBlockTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается перед добавлением инфоблока.
 */
class OnBeforeIBlockAddEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    public const PARAM_IBLOCK_TYPE_ID = IBlockTable::IBLOCK_TYPE_ID;
    public const PARAM_XML_ID = IBlockTable::XML_ID;
    public const PARAM_RIGHTS_MODE = 'RIGHTS_MODE';
    public const PARAM_RIGHTS = 'RIGHTS';

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array &$parameters)
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $this->parameters = ParameterBag::fromArrayReference($parameters);
    }

    /**
     * @throws BitrixEventsException
     *
     * @psalm-return non-empty-string
     */
    public function iblockType(): string
    {
        return $this->parameters->getNonEmptyString(self::PARAM_IBLOCK_TYPE_ID);
    }
}

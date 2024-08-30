<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Search;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\ParameterBag;
use Maximaster\BitrixTableClasses\Table\Search\SearchContentTable;
use Webmozart\Assert\Assert;

/**
 * Вызывается перед поисковой индексацией объекта.
 */
class BeforeIndexEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;

    public ParameterBag $parameters;

    /**
     * @psalm-param array<non-empty-string, mixed> $parameters
     */
    public function __construct(array $parameters)
    {
        Assert::allStringNotEmpty(array_keys($parameters));

        $this->parameters = ParameterBag::fromArray($parameters);
    }

    /**
     * @psalm-return array<non-empty-string, mixed>
     */
    public function product(): array
    {
        return $this->parameters->toArray();
    }

    public function cancelIndexing(): void
    {
        $this->parameters->set(SearchContentTable::TITLE, '');
        $this->parameters->set(SearchContentTable::BODY, '');
    }
}

<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\Search;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Webmozart\Assert\Assert;

/**
 * Событие перед созданием фильтра для проведения поиска.
 */
class OnSearchPrepareFilterEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;

    /**
     * Алиас таблицы содержимого поиска.
     *
     * @psalm-var non-empty-string
     *
     * @psalm-readonly
     */
    public string $searchContentTableAlias;

    /**
     * Поле фильтра.
     *
     * @var non-empty-string
     *
     * @psalm-readonly
     */
    public string $key;

    /**
     * Значение поля.
     *
     * @psalm-readonly
     */
    public $value;

    /**
     * @psalm-readonly
     */
    public string $sql = '';

    /**
     * @psalm-param non-empty-string $searchContentTableAlias
     * @psalm-param non-empty-string $key
     */
    public function __construct(string $searchContentTableAlias, string $key, $value)
    {
        Assert::stringNotEmpty($searchContentTableAlias, 'Алиас таблицы поиска не может быть пустой строкой.');
        Assert::stringNotEmpty($key, 'Ключ фильтра не может быть пустой строкой.');

        $this->searchContentTableAlias = $searchContentTableAlias;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Конфигурирует sql-запрос.
     */
    public function configureSql(string $sql): void
    {
        $this->sql = $sql;
    }

    public function product(): string
    {
        return $this->sql;
    }
}

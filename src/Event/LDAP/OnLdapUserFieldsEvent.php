<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event\LDAP;

use Maximaster\BitrixEventDispatcher\Contract\ProductiveEvent;
use Maximaster\BitrixEvents\Event\AutodetectedEventMetaTrait;
use Maximaster\BitrixEvents\Event\CancellableEventTrait;
use Webmozart\Assert\Assert;

/**
 * Событие, возникающее при конвертации полей пользователя, полученных из каталога LDAP,
 * в соответствующие поля пользователя сайта.
 */
class OnLdapUserFieldsEvent implements ProductiveEvent
{
    use AutodetectedEventMetaTrait;
    use CancellableEventTrait;

    private const USER_FIELD = 0;
    private const LDAP_FIELD = 1;

    /**
     * @psalm-var array{array<string, mixed>, array<string, mixed>}
     */
    private array $parameters;

    /**
     * @psalm-param array{array<string, mixed>, array<string, mixed>} $parameters
     */
    public function __construct(array &$parameters)
    {
        Assert::count($parameters, 2);

        $this->parameters = &$parameters;
    }

    public function setUserField(string $field, $value): void
    {
        $this->parameters[self::USER_FIELD][$field] = $value;
    }

    /**
     * @return mixed|null
     */
    public function ldapField(string $field)
    {
        return $this->parameters[self::LDAP_FIELD][$field] ?? null;
    }

    /**
     * Является ли указанное поле ldap не пустой строкой?
     */
    public function hasNonEmptyLdapField(string $field): bool
    {
        $value = $this->ldapField($field);

        return is_string($value) && $value !== '';
    }
}

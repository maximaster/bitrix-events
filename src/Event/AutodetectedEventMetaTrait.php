<?php

declare(strict_types=1);

namespace Maximaster\BitrixEvents\Event;

use Marcosh\LamPHPda\Maybe;
use Maximaster\BitrixValueObjects\Main\ModuleId;
use ReflectionClass;

trait AutodetectedEventMetaTrait
{
    /**
     * Идентификатор модуля события.
     *
     * @psalm-return Maybe<ModuleId>
     */
    public static function module(): Maybe/* <ModuleId> */
    {
        $nameParts = explode('\\', static::class);
        foreach ($nameParts as $partIndex => $namePart) {
            if (($nameParts[$partIndex - 1] ?? null) === 'Event') {
                return Maybe::just(new ModuleId(strtolower($namePart)));
            }
        }

        return Maybe::nothing();
    }

    /**
     * Имя события.
     *
     * @psalm-return non-empty-string
     */
    public static function name(): string
    {
        return preg_replace(
            '/(Event)$/',
            '',
            (new ReflectionClass(static::class))->getShortName()
        );
    }
}

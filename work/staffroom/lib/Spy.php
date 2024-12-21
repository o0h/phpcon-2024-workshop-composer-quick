<?php

declare(strict_types=1);

namespace Staffroom;

class Spy
{
    private static array $spy = [];

    public static function capture(mixed $val, string|int|null $key = null): void
    {
        if ($key === null) {
            self::$spy[] = $val;
            return;
        }
        array_key_exists($key, self::$spy) ? self::$spy[$key][] = $val : self::$spy[$key] = [$val];
    }

    public static function retrieve(string|int|null $key = null): ?array
    {
        if ($key === null) {
            return self::$spy;
        }
        return array_key_exists($key, self::$spy) ? self::$spy[$key] : null;
    }

    public static function forget(): void
    {
        self::$spy = [];
    }

}

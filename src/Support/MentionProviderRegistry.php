<?php

namespace Tilto\Commentable\Support;

class MentionProviderRegistry
{
    protected static string $sessionKey = 'mention_providers';

    public static function register(string $key, array $providers): void
    {
        $all = session()->get(static::$sessionKey, []);
        $all[$key] = $providers;
        session()->put(static::$sessionKey, $all);
    }

    public static function get(string $key): ?array
    {
        $all = session()->get(static::$sessionKey, []);

        return $all[$key] ?? null;
    }

    public static function forget(string $key): void
    {
        $all = session()->get(static::$sessionKey, []);
        unset($all[$key]);
        session()->put(static::$sessionKey, $all);
    }

    public static function clear(): void
    {
        session()->forget(static::$sessionKey);
    }
}

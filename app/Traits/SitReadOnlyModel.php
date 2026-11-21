<?php

namespace App\Traits;

trait SitReadOnlyModel
{
    private const READ_ONLY_MESSAGE = "Operación prohibida: el esquema 'sit' es de solo lectura.";

    public static function bootSitReadOnlyModel(): void
    {
        static::creating(fn () => throw new \RuntimeException(self::READ_ONLY_MESSAGE));
        static::updating(fn () => throw new \RuntimeException(self::READ_ONLY_MESSAGE));
        static::deleting(fn () => throw new \RuntimeException(self::READ_ONLY_MESSAGE));
        static::saving(fn () => throw new \RuntimeException(self::READ_ONLY_MESSAGE));
    }

    public function save(array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function saveQuietly(array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function saveOrFail(array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function saveOrIgnore(array $options = [], array|string|null $uniqueBy = null)
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function update(array $attributes = [], array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function updateQuietly(array $attributes = [], array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function updateOrFail(array $attributes = [], array $options = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function delete()
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function deleteQuietly()
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function deleteOrFail()
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public function forceDelete()
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public static function create(array $attributes = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public static function updateOrCreate(array $attributes, array $values = [])
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public static function insert(array $values)
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }


    public static function upsert(array $values, $uniqueBy, $update = null)
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }

    public static function truncate()
    {
        throw new \RuntimeException(self::READ_ONLY_MESSAGE);
    }
}

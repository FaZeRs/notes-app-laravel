<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UuidScopeTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    /**
     * Boot the uuid scope trait for a model.
     *
     * @return void
     */
    protected static function bootUuidScopeTrait()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }
}

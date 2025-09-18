<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        $record = static::query()->where('key', $key)->first();
        return $record ? $record->value : $default;
    }

    public static function set(string $key, $value)
    {
        return static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}

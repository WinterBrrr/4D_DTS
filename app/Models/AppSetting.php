<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class AppSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, $default = null)
    {
        try {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        } catch (QueryException $e) {
            // If the app_settings table doesn't exist yet, fall back to default
            return $default;
        }
    }

    public static function set(string $key, $value): void
    {
        try {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        } catch (QueryException $e) {
            // Silently ignore during early bootstrap (e.g., before migrations)
        }
    }

    public static function getBool(string $key, bool $default = false): bool
    {
        $value = static::get($key, $default ? 'true' : 'false');
        return in_array(strtolower((string)$value), ['true', '1', 'yes', 'on'], true);
    }

    public static function setBool(string $key, bool $value): void
    {
        static::set($key, $value ? 'true' : 'false');
    }
}

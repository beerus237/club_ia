<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class AdminSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)->first();

        return $setting?->value ?? $default;
    }

    /**
     * Set (create or update) a setting value.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Verify a plain-text password against the stored admin password hash.
     * Falls back to the documented default password if no setting has been
     * configured yet (e.g. migrations not run), so login always works.
     */
    public static function checkPassword(string $plainPassword): bool
    {
        $hash = static::get('admin_password');

        if (! $hash) {
            return $plainPassword === 'sdia2026';
        }

        return Hash::check($plainPassword, $hash);
    }

    /**
     * Update the admin password (stored hashed).
     */
    public static function updatePassword(string $newPassword): void
    {
        static::set('admin_password', Hash::make($newPassword));
    }
}

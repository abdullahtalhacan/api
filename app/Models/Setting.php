<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "name",
        "title",
        "desc",
        "value",
        "options",
        "element",
        "category"
    ];

    protected $casts = [
        'value' => 'array',
        'options' => 'array',
    ];

    public static function getFormattedSettings()
    {
        $settings = self::select('name', 'value')->get()->keyBy('name');
        $formattedSettings = [];
        foreach ($settings as $fieldName => $setting) {
            $formattedSettings[$fieldName] = $setting['value'];
        }
        return $formattedSettings;
    }
}

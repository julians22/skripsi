<?php

namespace App\Models\Global;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    const SETTING_TYPE_TEXT = 'text';
    const SETTING_TYPE_TEXTAREA = 'textarea';
    const SETTING_TYPE_IMAGE = 'image';

    // primary key
    protected $primaryKey = 'setting_key';

    // auto increment
    public $incrementing = false;

    // connection
    protected $connection = 'sqlite';

    protected $table = 'settings';

    protected $fillable = [
        'setting_key',
        'setting_value',
        'type'
    ];

    public function isImage()
    {
        return $this->type === self::SETTING_TYPE_IMAGE;
    }

    public function isText()
    {
        return $this->type === self::SETTING_TYPE_TEXT;
    }
}

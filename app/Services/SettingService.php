<?php

namespace App\Services;

use App\Models\Global\Setting;

class SettingService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Setting();
    }

    public function get($key)
    {
        return $this->model->where('setting_key', $key)->first();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function update($key, $value)
    {
        $setting = $this->get($key);
        if ($setting) {
            $setting->setting_value = $value;
            $setting->save();
        } else {
            $setting = $this->model->create([
                'setting_key' => $key,
                'setting_value' => $value,
            ]);
        }
        return $setting;
    }


}

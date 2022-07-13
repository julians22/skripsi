<?php

use App\Services\SettingService;

if (!function_exists('setting')) {

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function setting($key, $default = null)
    {
        $settingService = new SettingService();

        $setting = $settingService->get($key);
        if ($setting) {
            return $setting->setting_value;
        }else{
            return $default;
        }
    }
}

?>

<?php

use Carbon\Carbon;
use Faker\Core\Number;

if (! function_exists('appName')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function appName()
    {
        return setting('app_name', 'Point Of Sale');
    }
}

if (! function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     *
     * @param $time
     *
     * @return Carbon
     * @throws Exception
     */
    function carbon($time)
    {
        return new Carbon($time);
    }
}

if (! function_exists('homeRoute')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function homeRoute()
    {
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return 'admin.dashboard';
            }

            if (auth()->user()->isUser()) {
                return 'frontend.user.dashboard';
            }
        }

        return 'frontend.login';
    }
}

if (!function_exists('rupiah')) {
    /**
     * Format the price to rupiah.
     *
     * @param $price
     * @param int $decimals
     *
     * @return string
     */
    function rupiah($price, int $decimals = 2)
    {
        $value = "Rp. " . number_format($price, $decimals,',','.');
        return $value;
    }
}

if (!function_exists('clear_number')) {
    /**
     * Clear number from alphabet or character
     *
     * @param string $number
     * @return int
     */

     function clear_number($number)
     {
        $number = preg_replace("/[^0-9]/", "", $number);
        return (int) $number;
     }
}

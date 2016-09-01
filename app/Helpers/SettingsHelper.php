<?php

// namespace Helper\Services;

use App\Overtime;
use App\Settings;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class SettingsHelper {

    /*
     * Get a config in th setting table
     */
    public static function getConfig ($setting)
    {
        $settings = Settings::findOrFail(1);

        if ($settings->{$setting}) {
            return $settings->{$setting};
        } else {
            return null;
        }
    }
}
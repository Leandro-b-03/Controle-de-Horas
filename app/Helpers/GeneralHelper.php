<?php

// namespace Helper\Services;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\HTML;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class GeneralHelper {

    public static function getHoursTotal ($total, $nightly) {
        if ($total) {
            $total = new Carbon($total);
            
            if ($nightly != 0) {
                $nightly = new Carbon($nightly);

                if ($nightly->hour > 1) {
                    if ($nightly->minute > 1)
                        $diffTime = $total->addHours($nightly->toTimeString())->addMinutes($nightly->toTimeString());
                    else
                        $diffTime = $total->addHours($nightly->toTimeString())->addMinutes();
                } else {
                    if ($nightly->minute > 1)
                        $diffTime = $total->addHour()->addMinutes($nightly->toTimeString());
                    else
                        $diffTime = $total->addHour()->addMinute();
                }
            }

            return $total->toTimeString();
        } else {
            return "00:00:00";
        }
    }

    public static function getWeekDay ($workday) {
        $date = strftime('%A', strtotime($workday));

        $date = ucwords(strtolower($date));

        foreach (array('-', '\'') as $delimiter) {
            if (strpos($date, $delimiter)!== false) {
                $date = implode($delimiter, array_map('ucfirst', explode($delimiter, $date)));
            }
        }

        return utf8_encode($date);
    }
}
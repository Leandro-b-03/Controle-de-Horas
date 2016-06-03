<?php

// namespace Helper\Services;

use App\Overtime;
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

                if ($nightly->hour > 1)
                    $total->addHours($nightly->toTimeString());
                else if ($nightly->hour == 1)
                    $total->addHour();

                if ($nightly->minute > 1)
                    $total->addMinutes($nightly->toTimeString());
                else if ($nightly->minute == 1)
                    $total->addMinute();

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

    public static function withoutSeconds ($time) {
        return date('g:ia', strtotime($time));
    }

    public static function getBgStatus ($status) {
        switch ($status) {
            case 1:
                return 'bg-blue';
                break;
            case 13:
                return 'bg-green';
                break;
            
            default:
                return 'bg-red';
                break;
        }
    }

    public static function getOvertime ($user_id) {
        // Get the overtime
        $overtime = Overtime::where('user_id', $user_id)->get()->first();

        if ($overtime)
            return $overtime->hours;
        else
            return '00:00:00';
    }
}
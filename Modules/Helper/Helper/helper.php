<?php

use App\Media;
use App\User;
use App\UserSentinel;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Dingo\Blueprint\Annotation\Transaction;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Modules\Settings\Entities\Setting;

const NUMBER = 'number';
const PERCENT = 'percent';

const USER = 'user';

const ACTIVE = 'active';
const INACTIVE = 'inactive';

const APPROVED = 'approved';
const UNAPPROVED = 'unapproved';
const PENDINGAPPROVAL = 'pending-approval';


function getDateFormat($created_at)
{
    return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s');
}

function formatCurrency($price)
{
    if (!empty($price)) {
        return number_format($price, 2, ',', '.');
    } else {
        return FALSE;
    }
}

function getSetting($key)
{
    if (!empty($key)) {
        $setting = Setting::where('key', $key)->first();

        if ($setting && !empty($setting->value) && $setting->value != '')
            return $setting->value;
        else
            return FALSE;
    } else {
        return FALSE;
    }
}

function roundNearestHundredUp($number)
{
    return ceil( $number / 100 ) * 100;
}

function trimCurrency($string){
    // Remove everything except number, and dot
    $val =  preg_replace('/[^\d\.]/', '', $string);
    return !empty($val)?$val:0.00;
}

function formatPoint($point)
{
    if (!empty($point)) {
        return number_format($point, 0, '.', '.');
    } else {
        return false;
    }
}


// Setting default response for API request
function setDefaultAPIResponse(){
    $response = [
        'status' => 'error',
        'code' => 500,
    ];

    return $response;
}

function sendEmail($from, $recipient, $subject, $view, $data)
{
    try {
        Mail::send($view, $data, function ($message) use ($from, $recipient, $subject) {
            $message->from($from['email'], $from['name']);
            $message->to($recipient)->subject($subject);
        });
    } catch (\Exception $e) {
        return false;
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }

    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }

    //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);

    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }

    return $trimmed_text;
}

/**
 * Generate random number - 4 digit
 * used in process generate referral code
 */
function uniqueMicrotime()
{
    return substr(strtotime('now'), -1) . substr(microtime(), 4, 3);
}

function generateAPIResponseError(\Exception $e, $defaultMessage = 'Terjadi kesalahan sistem, silahkan coba lagi'){
    if($e->getCode() == 506)
        return $e->getMessage();
    return $defaultMessage;
}

// Get working days to count
function getWorkingDays($startDate, $endDate){
    // Process date to count workdays and 
    $workingDays = [1, 2, 3, 4, 5]; // Monday - Friday
    $holidayDays = []; // to-be implemented

    $from = new \DateTime($startDate);
    $to = new \DateTime($endDate);
    $to->modify('+1 day');
    $interval = new \DateInterval('P1D');
    $periods = new \DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $days++;
    }
    return $days;
}

function getWorkingDaysDate($startDate, $endDate){
    // Process date to count workdays and 
    $workingDays = [1, 2, 3, 4, 5]; // Monday - Friday
    $holidayDays = []; // to-be implemented

    $from = new \DateTime($startDate);
    $to = new \DateTime($endDate);
    $to->modify('+1 day');
    $interval = new \DateInterval('P1D');
    $periods = new \DatePeriod($from, $interval, $to);

    $array = [];
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $array[] = $period->format('Y-m-d');
    }
    return $array;
}
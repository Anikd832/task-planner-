<?php

/**
 * Predefined Messages
 */
define('SUCCESS', 'Successfully created');
define('FAIL', 'Failed to create');
define('UPDATE_SUCCESS', 'Successfully updated');
define('UPDATE_FAIL', 'Failed to update');
define('SERVER_ERROR', 'Internal server error!');
define('DELETE_SUCCESS', 'Successfully deleted');
define('DELETE_FAIL', 'Failed to delete');
define('UNAUTHORIZED', 'These credentials do not match our records.');
define('PERMISSION_DENIED', 'Insufficient Permissions!');
define('PAGINATE_LIMIT', 10);
define('DEFAULT_ERROR', 'Something went wrong! Try again.');

/**
 * Flash message with label
 * @Param String $message
 * @param String $level ='info'
 * @Return null
 */
if (!function_exists('flash')) {
    function flash($message, $level = 'success', $important = false)
    {
        session()->flash('flash_message', $message);
        session()->flash('flash_message_level', $level);
        session()->flash('flash_important', $important);
    }
}

/**
 * Flash message with label
 * @Param String $message
 * @param String $level ='info'
 * @Return null
 */
if (!function_exists('flashAlert')) {
    function flashAlert($heading, $message, $level = 'success')
    {
        session()->flash('flash_heading', $heading);
        session()->flash('flash_message', $message);
        session()->flash('flash_message_level', $level);
    }
}

/**
 * Remove spaces from string
 */
if (!function_exists('removeSpace')) {
    function removeSpace($str, $replaceBy = '')
    {
        return preg_replace('/\s+/', $replaceBy, $str);
    }
}

/**
 * Common json response with datas
 */
if (!function_exists('respondJson')) {
    function respondJson($data, $key = 'data', $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            "{$key}" => $data,
        ], $code);
    }
}

/**
 * Common json success response
 */
if (!function_exists('respondSuccess')) {
    function respondSuccess($message = '', $data = [], $key = 'data', $code = 200, $status = true)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            "{$key}" => $data
        ], $code);
    }
}

/**
 * Common json error response
 */
if (!function_exists('respondError')) {
    function respondError($message = '', $code = 500, $data = [], $key = 'data', $status = false)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            "{$key}" => $data
        ], $code);
    }
}

/**
 * Date Format
 */
if (!function_exists('dateFormat')) {
    function dateFormat($date, $format = 'l, d F Y', $replaceBy = null)
    {
        if (!empty($date) && !empty($replaceBy)) {
            $date = str_replace('/', $replaceBy, $date);
        }
        return $date ? date($format, strtotime($date)) : null;
    }
}

/**
 * Get Settings & store into cache
 */
if (!function_exists('settings')) {
    function settings()
    {
        return true;
    }
}

/* Get current route name */
if (!function_exists('currentRoute')) {
    function currentRoute()
    {
        return \Request::route()->getName();
    }
}

/* Get current path or url name */
if (!function_exists('currentUrlPath')) {
    function currentUrlPath()
    {
        return request()->path();
    }
}

/* Get current route name */
if (!function_exists('getSemester')) {
    function getSemester($id)
    {
        return \App\Models\Semester::whereId($id)->first();
    }
}

if (!function_exists('manageRole')) {
    function manageRole($role)
    {
        return $role;
    }
}

// remove slash http(s) from given url
if (!function_exists('urlToStr')) {
    function urlToStr($url)
    {
        return preg_replace("#^[^:/.]*[:/]+#i", "", preg_replace("{/$}", "", config('app.url')));
    }
}

// remove slash http(s) from given url
if (!function_exists('diffOfTwoDate')) {
    function diffOfTwoDate($from, $to)
    {
        $begin = new DateTime($from);
        $end = new DateTime($to);
        return date_diff($begin, $end);
    }
}

// remove slash http(s) from given url
if (!function_exists('convertBengaliDate')) {
    function convertBengaliDate($dateTime)
    {
        return en2bn(date('d F, Y', strtotime($dateTime)));
    }
}

if (!function_exists('convertBengaliDateTime')) {
    function convertBengaliDateTime($dateTime)
    {
        return en2bn(date('h:i:s a, d F, Y', strtotime($dateTime)));
    }
}

if (!function_exists('convertBengaliTime')) {
    function convertBengaliTime($dateTime)
    {
        return en2bn(date('h:i a', strtotime($dateTime)));
    }
}

if (!function_exists('convertTime')) {
    function convertTime($dateTime)
    {
        return date('h:i a', strtotime($dateTime));
    }
}

if (!function_exists('en2bn')) {
    function en2bn($number)
    {
        $english_digits = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December', 'Option-1', 'Option-2', 'Option-3', 'Option-4'
        );
        $bengali_digits = array(
            '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
            'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'ক)', 'খ)', 'গ)', 'ঘ)'
        );
        return str_replace($english_digits, $bengali_digits, $number);
    }
}

if (!function_exists('convertBnDateToEn')) {
    function convertBnDateToEn($dateTime)
    {
        return date('d F, Y', strtotime(bn2en($dateTime)));
    }
}
if (!function_exists('bn2en')) {
    function bn2en($number)
    {
        $english_digits = array(
            '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন',
            'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
        );
        $bengali_digits = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        );
        return str_replace($english_digits, $bengali_digits, $number);
    }
}

if (!function_exists('mobileNumberFormat')) {
    function mobileNumberFormat($number)
    {
        $contact_number = '';
        $length = '';
        if (substr($number, 0, 2) === '01') {
            $length = 11;
            $contact_number = '88' . $number;
        } else if (substr($number, 0, 1) === '1') {
            $length = 10;
            $contact_number = '880' . $number;
        } else if (substr($number, 0, 5) === '+8801') {
            $length = 14;
            $contact_number = substr($number, 1);
        } else if (substr($number, 0, 4) === '8801') {
            $length = 13;
            $contact_number = $number;
        }
        /**
         * Finally match length and Check if all is number
         */
        return (strlen($number) === $length) &&  preg_match('/^[0-9]*$/', $contact_number) ? $contact_number : null;
    }
}

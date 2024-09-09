<?php

if (!function_exists('getDayList')) {
    function getDayList()
    {
        return [
            'Monday'    => __('monday'),
            'Tuesday'   => __('tuesday'),
            'Wednesday' => __('wednesday'),
            'Thursday'  => __('thursday'),
            'Friday'    => __('friday'),
            'Saturday'  => __('saturday'),
            'Sunday'    => __('sunday'),
        ];
    }
}

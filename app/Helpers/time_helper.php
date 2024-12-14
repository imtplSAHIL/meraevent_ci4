<?php

if (!function_exists('allTimeFormats')) {
    /**
     * Format a date/time according to specified format type
     *
     * @param string|null $inputDate The input date to format
     * @param int $formatType The type of format to use (1-19)
     * @return string The formatted date/time string
     */
    function allTimeFormats($inputDate, $formatType) {
        if (!$inputDate) {
            $inputDate = date('Y-m-d H:i:s');
        }

        return match ($formatType) {
            1 => date('m/d/Y', strtotime($inputDate)),
            2 => date('g:i A', strtotime($inputDate)),
            3 => date('l\, jS M Y', strtotime($inputDate)),
            4 => date('h:i A', strtotime($inputDate)),
            6 => date('Y-m-d 00:00:00', strtotime($inputDate)),
            7 => date('d M Y, h:i A', strtotime($inputDate)),
            8 => date('F j, Y', strtotime($inputDate)),
            9 => date('Y-m-d', strtotime($inputDate)),
            11 => date('Y-m-d H:i:s', strtotime($inputDate)),
            12 => date('H:i:s', strtotime($inputDate)),
            14 => date('Ymd', strtotime($inputDate)),
            15 => date('F d, Y', strtotime($inputDate)),
            16 => date('h:i a', strtotime($inputDate)),
            17 => date('Y', strtotime($inputDate)),
            18 => date('F d, Y,h:i A', strtotime($inputDate)),
            19 => gmdate('Y-m-d\TH:i:s.u\Z', strtotime($inputDate)),
            default => date('Y-m-d H:i:s', strtotime($inputDate)),
        };
    }
}

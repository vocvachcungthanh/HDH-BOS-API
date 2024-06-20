<?php
if (!function_exists('convertToMinutes')) {
    function convertToMinutes($timeString)
    {
        $time = 0;
        preg_match_all('/(\d+)([smhdw])/i', $timeString, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $value = (int) $match[1];
            $unit = strtolower($match[2]);

            switch ($unit) {
                case 's':
                    $time += $value / 60;
                    break;
                case 'm':
                    $time += $value;
                    break;
                case 'h':
                    $time += $value * 60;
                    break;
                case 'd':
                    $time += $value * 60 * 24;
                    break;
                case 'w':
                    $time += $value * 60 * 24 * 7;
                    break;
            }
        }

        return $time;
    }
}

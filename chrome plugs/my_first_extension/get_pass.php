<?php
$year_start = 1997;
$year_end = 1997;

$month_start = 1;
$month_end = 5;

$day_start = 1;
$day_end = 31;

$result = null;
$i = 0;

for($year = $year_start; $year <= $year_end; $year++) {
    for($month = $month_start; $month <= $month_end; $month++) {
        for($day = $day_start; $day <= $day_end; $day++) {
            $result[$i] = "\"";

            if($day < 10) {
                $result[$i] .= '0' . $day;
            } else {
                $result[$i] .= $day;
            }

            if($month < 10) {
                $result[$i] .= '0' . $month;
            } else {
                $result[$i] .= $month;
            }

            $result[$i] .= $year;

            $result[$i] .= "\"";

            $i++;
        }
    }
}

echo implode(',', $result);

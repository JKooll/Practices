<?php
trait Common
{
    private function getUnits()
    {
        $units_str = ENV('UNITS');
        $units_arr = explode('+', $units_str);
        return $units_arr;
    }

    private function getClasses()
    {
        $classes_str = ENV('CLASSES');
        $classes_arr = explode('+', $classes_str);
        return $classes_arr;
    }

    private function getTag()
    {
        return ENV('TAG');
    }
}

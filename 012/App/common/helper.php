<?php

function env($key, $default)
{
    return get_env($key) ? get_env($key) : $default;
}

function get_env($key)
{

}
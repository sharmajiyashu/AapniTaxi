<?php

if (!function_exists('debug')) {

    function debug($value) {
        return str_replace(',', '', $value);
    }

}


?>
<?php

if (!function_exists('dump')) {
    /**
     * Dumps information about a variable
     * @param mixed $values @param mixed $values Expression to dump
     */
    function dump(mixed ...$values) {
        if (count($values)) {
//            echo "\e[33m";
            var_dump(...$values);
//            echo "\e[0m\n";
        } else {
            echo 'NULL' . PHP_EOL;
        }
    }
}

if (!function_exists('dd')) {
    /**
     * Dump & Die
     * @param mixed $values Expression to dump
     */
    function dd(mixed ...$values) {
        dump($values);
        exit(1);
    }
}

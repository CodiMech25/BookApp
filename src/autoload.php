<?php

spl_autoload_register(function (string $class): bool {
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (is_file($file)) {
        require_once($file);
        return true;
    }

    return false;
});

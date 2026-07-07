<?php

// Developed with namespaces automatically.
// Understand that possibly this is not required, but decided that more simple will be to implement autoload than remove
// namespaces.
spl_autoload_register(function ($class) {
    if (!str_starts_with($class, 'App\\')) {
        return;
    }

    $filepath = str_replace('App\\', '', $class);
    $filepath = str_replace('\\', '/', $filepath);
    require_once __DIR__ . '/' . $filepath . '.php';
});

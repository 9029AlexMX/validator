<?php

// Developed with namespaces automatically.
// Understand that possibly this is not required, but decided that more simple will be to implement autoload than remove
// namespaces.
spl_autoload_register(function($class) {
    $filepath = str_replace('\\', '/', substr($class, 4));
    require_once __DIR__ . '/'.$filepath.'.php';
});

?>
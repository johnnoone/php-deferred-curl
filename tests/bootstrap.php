<?php

spl_autoload_register(function ($classname) {
    $path = strtr($classname, array('\\' => DIRECTORY_SEPARATOR));
    $filename = realpath(__DIR__ . '/../src/' . $path . '.php');
    if ($filename) {
        include $filename;
    }

    $filename = realpath(__DIR__ . '/' . $path . '.php');
    if ($filename) {
        include $filename;
    }

    // Fallback with included paths
    foreach (explode(PATH_SEPARATOR, get_include_path()) as $dir) {
        $filename = realpath($dir . '/' . $path . '.php');
        if ($filename) {
            include $filename;
        }
    }
});

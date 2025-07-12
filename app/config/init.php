<?php
// Start session
session_start();

// Load Config
require_once 'config.php';
require_once 'database.php';

// Autoload Core Libraries
spl_autoload_register(function($className) {
    $paths = [
        'models/',
        'lib/',
        'controllers/'
    ];
    
    foreach($paths as $path) {
        $file = __DIR__ . '/../' . $path . $className . '.php';
        if(file_exists($file)) {
            require_once $file;
            return;
        }
    }
}); 
<?php

use App\Kernel;

// Automatically loads the files needed to run the application
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    // Creates a new instance of Kernel depending on the environment and debug mode
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};

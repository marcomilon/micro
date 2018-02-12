<?php

namespace micro;

use micro\Application;

abstract class Model extends \micro\db\ActiveRecord
{
    
    public static function getConfig() {
        return Application::getConfig();
    }
}
<?php

namespace micro\helpers\form;

use micro\Application;

class Builder extends \micro\form\Builder
{
    
    public function __construct() 
    {
        $config = Application::getConfig();
        if(isset($config['form'])) {
            parent::__construct($config['form']);
        }
    }
    
}
<?php

namespace micro;

class Controller {
    
    public function render($view, $params = [])
    {
        
    }
    
    public function loadLayout() 
    {
        include dirname(__DIR__) . '/../web/src/layout/header.php';
    }

}

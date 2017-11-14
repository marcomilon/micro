<?php

namespace micro;

class Controller {
    
    private $viewPath;
    private $basePath;
    
    public function __construct() {
        $classInfo = new \ReflectionClass($this);
        $className = $classInfo->getShortName();
        
        $this->basePath = dirname($classInfo->getFileName(), 2);
        $this->viewPath = $this->basePath . '/views/' . strtolower(str_replace(Application::CONTROLLER_SUFFIX, '', $className));
    }
    
    public function render($view, $params = [])
    {
        $content = $this->loadView($view, $params);
        return $this->loadLayout($content);
    }
    
    private function loadLayout($content) 
    {
        ob_start();
        require $this->basePath . '/views/layouts/main.php';
        $out = ob_get_clean();
        return $out;        
    }
    
    private function loadView($view, $params) {
        ob_start();
        extract ($params);
        require $this->viewPath . '/' . $view . '.php';
        $out = ob_get_clean();
        
        return $out;
    }
}

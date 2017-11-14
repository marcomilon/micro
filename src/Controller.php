<?php

namespace micro;

class Controller {
    
    use Response;
    
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
        try {
            $content = $this->renderView($view, $params);
            $out = $this->renderLayout($content);
            return $out;
        } catch (\Exception $e) {
            $this->send($e->getMessage(), 500);
        }
    }
    
    private function renderView($view, $params) 
    {    
        $file = $this->viewPath . '/' . $view . '.php';
        return $this->renderFile($file, $params);
    }
    
    private function renderLayout($content) 
    {
        $params = ['content' => $content];
        $file = $this->basePath . '/views/layouts/main.php';
        return $this->renderFile($file, $params);
    }
    
    private function renderFile($file, $params) {
        if (file_exists($file)) {
            ob_start();
            extract ($params);
            require $file;
            $out = ob_get_clean();        
            return $out;
        } else {
            throw new \Exception("The view file does not exist: $file");
        }
    }
}

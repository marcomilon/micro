<?php

namespace micro;

/**
* Controller represent an instance of the controller that render the view. 
*
* The controller class have the responsability to render the web page
* 
* @author Marco Milon <marco.milon@gmail.com>
*/
class Controller 
{
    
    /**
    * @var object is a trait responsable to send the response to the browser
    */
    use Response;
    
    /**
    * @var string the path to the view file to be rendered
    */
    private $viewPath;
    
    /**
    * @var string the path to the current controller class file
    */
    private $basePath;
    
    public $parameters = [];
    
    /**
    * Set to class variables $viewPath and the $basePath. It Use reflection 
    * to determine the $viewPath and the $basePath.
    */
    public function __construct() {
        $classInfo = new \ReflectionClass($this);
        $className = $classInfo->getShortName();
        
        $this->nameSpace = $classInfo->getNamespaceName();
        
        $this->basePath = dirname($classInfo->getFileName(), 2);
        $this->viewPath = $this->basePath . '/views/' . strtolower(str_replace(Application::CONTROLLER_SUFFIX, '', $className));
    }
    
    /**
    * Render a view. First it renders the view and the it renders the layout.
    *
    * @param string $view is the filename of the view to be rendered
    * @param array $params are the variables to be rendered on the view file
    */
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
    
    /**
    * Render a view without the layout.
    *
    * @param string $view is the filename of the view to be rendered
    * @param array $params are the variables to be rendered on the view file
    */    
    public function renderPartial($view, $params = [])
    {
        try {
            return $this->renderView($view, $params);
        } catch (\Exception $e) {
            $this->send($e->getMessage(), 500);
        }
    }
    
    /**
    * Render the view file. It use the class variable $viewPath.
    *
    * @param string $view is the filename of the view to be rendered
    * @param array $params are the variables to be rendered on the view file
    */
    private function renderView($view, $params) 
    {    
        $file = $this->viewPath . '/' . $view . '.php';
        if(is_readable($file)) {
            return $this->renderFile($file, $params);
        } 
        
        throw new \Exception("The view file does not exist: $file");
    }
    
    /**
    * Render the layout file
    * 
    * The default layout file is views/layouts/main.php
    *
    * @param string $content is a string that hold the rendered webpage
    * @return string with the rendered view ready to be sent to the browser
    */
    private function renderLayout($content) 
    {
        $params = ['content' => $content];
        $file = $this->basePath . '/views/layouts/main.php';
        if(is_readable($file)) {
            return $this->renderFile($file, $params);
        } elseif(strpos($this->nameSpace, 'modules') !== false) {
            $basePath = dirname($this->basePath, 2);
            $file = $basePath . '/views/layouts/main.php';
            if(is_readable($file)) {
                return $this->renderFile($file, $params);
            }
        }
        
        throw new \Exception("The view file does not exist: $file");
    }
    
    /**
    * Render a file. 
    * 
    * The default layout file is views/layouts/main.php
    *
    * @param string $file is the filename of the view
    * @throws Exception if $file is not found
    * @param array $params are the variable to be rendered in the view
    */
    private function renderFile($file, $params) {
        ob_start();
        extract ($params);
        require $file;
        $out = ob_get_clean();        
        return $out;
    }
    
}
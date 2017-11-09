<?php

namespace micro;

class Application 
{
    
    const DEFAULT_CONTROLLER = 'DefaultCtrl';
    const DEFAULT_ACTION = 'index';
    
    public function __construct()
    {
        set_error_handler([$this, 'handleError']);
        error_reporting(E_ALL | E_STRICT);
    }
    
    public function run($queryString) 
    {   
        $rParameter = isset($queryString['r']) ? filter_var($queryString['r'], FILTER_SANITIZE_STRING) : '';
        $route = $this->parseRoute($rParameter);
        
        $controller = $this->instantiateController($route);
    }
        
    public function parseRoute($rParameter) 
    {   
        if (preg_match('/^([a-zA-Z]+)\/([a-zA-Z]+)$/', $rParameter, $matches)) {
            $controller = ucfirst(strtolower($matches[1])). 'Ctrl';
            $action = $matches[2];
        } elseif (preg_match('/^([a-zA-Z]+)\/?$/', $rParameter, $matches)) {
            $controller = ucfirst(strtolower($matches[1])) . 'Ctrl';
            $action = self::DEFAULT_ACTION;
        } else {
            $controller = self::DEFAULT_CONTROLLER;
            $action = self::DEFAULT_ACTION;
        }
        
        return [
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    public function instantiateController($route) 
    {
        try {
            $controller = '\app\controller\\' . $route['controller'];
            $obj = new $controller;
        } catch (\Throwable $e) {
            $this->sendResponse('Not found', 404);
        } catch (\Exception $e) {
            $this->sendResponse('Not found', 404);
        }
        
        return $obj;
    }
    
    public function callAction($object, $method, $arguments = []) 
    {
        $response = call_user_func_array([$object, $method], $arguments);
    }
    
    public function sendResponse($body, $status) 
    {
        http_response_code($status);
        echo $body;
    }
    
    public function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        if (!headers_sent()) {
            $this->sendResponse($errno, 500);        
        }
        /* Don't execute PHP internal error handler */
        return true;
    }
    
}
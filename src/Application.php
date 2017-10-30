<?php

namespace micro;

class Application 
{
    
    const DEFAULT_CONTROLLER = 'DefaultCtrl';
    const DEFAULT_ACTION = 'index';
    
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
    
    public function instantiateController($route) {
        $controller = '\app\controller\\' . $route['controller'];
        return new $controller;
    }
    
    
    public function response($object, $method, $arguments = []) {
        $response = call_user_func_array([$object, $method], $arguments);
    }
    
}

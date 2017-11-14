<?php

namespace micro;

class Application 
{
    
    const CONTROLLER_SUFFIX = 'Ctrl';
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
        $controllerName = $route['controller'];
        $actionName = $route['action'];
        
        unset($queryString['r']);
        
        $controller = $this->instantiateController($controllerName);
        $this->callAction($controller, $actionName, $queryString);
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
    
    public function instantiateController($controllerName) 
    {
        try {
            $controller = '\app\controller\\' . $controllerName;
            $object = new $controller;
            return $object;
        } catch (\Throwable $e) {
            $this->sendResponse('Not found', 404);
        } catch (\Exception $e) {
            $this->sendResponse('Not found', 404);
        }
    }
    
    public function callAction($controller, $action, $arguments = []) 
    {
        $hasExpectedParatemers = true;
        if(is_object($controller)) {
            if(is_callable([$controller, $action])) {
                $parameters = [];
                $r = new \ReflectionMethod($controller, $action);
                $params = $r->getParameters();
                
                foreach ($params as $param) {
                    $getParameter = $param->getName();
                    $paramValue = isset($arguments[$getParameter]) ? filter_var($arguments[$getParameter], FILTER_SANITIZE_STRING) : '';
                    if(!empty($paramValue)) {
                        $parameters[$getParameter] = $paramValue;
                    } else {
                        $hasExpectedParatemers = false;
                    }
                }
                
                if($hasExpectedParatemers) {
                    $response = call_user_func_array([$controller, $action], $parameters);
                    $this->sendResponse($response, 200);
                } else {
                    $this->sendResponse('Bad request', 400);
                }
                
            } else {
                $this->sendResponse('Not found', 404);
            }
        }
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
        
        $this->sendResponse($errfile."[".$errline."]: ". $errstr, 500);
        /* Don't execute PHP internal error handler */
        return true;
    }
    
    private function isResponseSent() {
        return $this->responseSent === true;
    }
    
}
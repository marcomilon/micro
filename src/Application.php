<?php

namespace micro;

/**
 * Application represent an instance of the web app. 
 *
 * It uses the method run to determine with Controller to instanciate and with method to execute.
 * 
 * How it works?
 * The method run() recive a query string of the form r=controller/action. Then it will try to 
 * instanciate a Class named ControllerCtrl if succefull it will try to execute a method call action that 
 * belong to the class ControllerCtrl.
 *
 * @author Marco Milon <marco.milon@gmail.com>
 */
class Application 
{
    /**
     * @var object is a trait responsable to send the response to the browser
     */
    use Response;
    
    /**
     * @var string the default suffix of the classes representing the controllers
     */
    const CONTROLLER_SUFFIX = 'Ctrl';
    
    /**
     * @var string the name of the default controller
     */
    const DEFAULT_CONTROLLER = 'DefaultCtrl';
    
    /**
     * @var string the name of the default action
     */
    const DEFAULT_ACTION = 'index';
    
    public function __construct()
    {
        set_error_handler([$this, 'handleError']);
        error_reporting(E_ALL | E_STRICT);
    }
    
    /**
     * Instanciate a controller an call the method requested with the queryString.
     * @param string $queryString query string of the form r=controller/action
     */
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
    
    /**
     * Parse the value of the r parameter in the GET request.
     *
     * @param string $rParameter is a string of the form controller/action
     * @return array with the controller to instanciate and method name to execute
     */
    private function parseRoute($rParameter) 
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
    
    /**
     * Creates an instance of the controller. In case the controllar cannot be
     * instanciated the method will send a 404 or 500 response.
     *
     * @param string $controllerName is the name of the controller class
     * @return object and instance of the controller class
     */
    private function instantiateController($controllerName) 
    {
        try {
            $controller = '\app\controllers\\' . $controllerName;
            $object = new $controller;
            return $object;
        } catch (\Throwable $e) {
            $this->send($e->getMessage(), 500);
        } catch (\Exception $e) {
            $this->send('Not found', 404);
        }
    }
    
    /**
     * Call the method requested. The method belongs to the controller class.
     *
     * If the action is not found it will send a 404 response.
     * If the action doesn't have the required parameter it will send a 400 response.
     * If everything goes without problems it will send a 200 response with the rendered page.
     *
     * @param object $controller is an instace of the controller class
     * @param string $action is the name of the method to be call
     * @param array $arguments is an array with the arguments needed by the action method
     */
    private function callAction($controller, $action, $arguments = []) 
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
                    $this->send($response, 200);
                } else {
                    $this->send('Bad request', 400);
                }
                
            } else {
                $this->send('Not found', 404);
            }
        }
    }
        
    public function handleError($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }
        
        $this->send($errfile."[".$errline."]: ". $errstr, 500);
        /* Don't execute PHP internal error handler */
        return true;
    }
    
}
<?php 

namespace micro\test\units;

require_once __DIR__ . '/../../CustomCtrl.php';

use atoum;

class Application extends atoum
{
    
    public function testParseRoute()
    {
        $queryStrings = [
            'route/action' => ['controller' => 'RouteCtrl', 'action' => 'action'], 
            'route/' => ['controller' => 'RouteCtrl', 'action' => 'index'], 
            'route' =>  ['controller' => 'RouteCtrl', 'action' => 'index'],
            '/action' =>  ['controller' => 'DefaultCtrl', 'action' => 'index'],
            '/' =>  ['controller' => 'DefaultCtrl', 'action' => 'index'],
            '///' =>  ['controller' => 'DefaultCtrl', 'action' => 'index'],
            '1234' =>  ['controller' => 'DefaultCtrl', 'action' => 'index'],
            '' =>  ['controller' => 'DefaultCtrl', 'action' => 'index']
        ];
        
        $app = new \micro\Application();
        
        foreach($queryStrings as $k => $v) {
            $parse = $app->parseRoute($k);
            $this->array($parse)
            ->string['controller']->isEqualTo($v['controller'])
            ->string['action']->isEqualTo($v['action']);
        }
    }
    
    public function testController() 
    {   
        $this->given($app = new \micro\Application())
            ->and($route = $app->parseRoute('custom/action'))
            ->then
            ->object($app->instantiateController($route));
    }    
    
    public function testAction() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $route = $app->parseRoute('custom/index');
                $obj = $app->instantiateController($route);
                $app->callAction($obj, $route['action']);
            }
        )->isEqualTo("Hello world");
    } 
    
    public function testActionWithArguments() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $_GET['arg1'] = "arg1";
                $_GET['arg2'] = "arg2";
                $route = $app->parseRoute('custom/action');
                $obj = $app->instantiateController($route);
                $app->callAction($obj, $route['action'], $_GET);
            }
        )->isEqualTo("arg1,arg2");
    }
        
    public function testControllerNotFound() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $route = $app->parseRoute('notvalid/action');
                $app->instantiateController($route);
            }
        )->isEqualTo("Not found");
    }
    
    public function testActionNotFound() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $route = $app->parseRoute('custom/invalid');
                $obj = $app->instantiateController($route);
                $app->callAction($obj, $route['action']);
            }
        )->isEqualTo("Not found");
    }
    
    public function testActionWithEmptyRequiredArguments() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $route = $app->parseRoute('custom/action');
                $obj = $app->instantiateController($route);
                $app->callAction($obj, $route['action']);
            }
        )->isEqualTo("Bad request");
    }
    
    public function testActionWithMissingArguments() 
    {   
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $_GET['arg1'] = "arg1";
                $route = $app->parseRoute('custom/action');
                $obj = $app->instantiateController($route);
                $app->callAction($obj, $route['action'], $_GET);
            }
        )->isEqualTo("Bad request");
    }
    
}
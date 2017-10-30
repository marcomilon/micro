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
    
    public function testInstantiateController() 
    {   
        
        $this->given($app = new \micro\Application())
            ->and($route = $app->parseRoute('custom/action'))
            ->then
            ->object($app->instantiateController($route));
        
    }
    
    
    public function testNotFoundController() 
    {   
        
        $this->given($app = new \micro\Application())
            ->and($route = $app->parseRoute('notfound/action'))
            ->and($obj = $app->instantiateController($route))
            ->exception(
                function() use($obj) {
                    // this code throws an exception: throw new \Exception;
                    $obj->instantiateController($route);
                }
            );
        
    }
    
}
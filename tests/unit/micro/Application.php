<?php 

namespace micro\test\units;

require_once __DIR__ . '/../../app/controllers/CustomCtrl.php';
require_once __DIR__ . '/../../app/models/HelpCategory.php';

use atoum;

class Application extends atoum
{

    public function testRun() {        
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/index'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Hello world");
    }
    
    public function testRunWithParameters() {        
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/action',
                    'arg1' => 'arg1',
                    'arg2' => 'arg2'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("arg1,arg2");
    }
    
    public function testRunWithMissingParameters() {        
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/action'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Bad request");
    }
    
    public function testRunControllerNotFound() {        
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'notvalid/action'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Class '\app\controllers\NotvalidCtrl' not found");
    }
    
    public function testRunActionNotFound() {        
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/invalid'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Not found");
    }
    
    public function testRunActionConfig() {
        
        $config = [
            'key' => 'Config value'
        ];
        
        $app = new \micro\Application($config);
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/config'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Config value");
    }
    
    public function testRunActionRenderConfig() {
        $expectedRendering = dirname(__FILE__) . '/../../data/renderConfig.html';
        
        $config = [
            'key' => 'Config value'
        ];
        
        $app = new \micro\Application($config);
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/viewconfig'
                ];
                $app->run($queryString);
            }
        )->isEqualToContentsOfFile($expectedRendering);
    }
    
    public function testRunModel() {
        
        $config = [
            'key' => 'Config value',
            'db' => [
                'servername' => '127.0.0.1',
                'username' => 'root',
                'password' => 'fullstack',
                'database' => 'mysql'
            ]
        ];
        
        $app = new \micro\Application($config);
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/record'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Geographic");
    }
    
}
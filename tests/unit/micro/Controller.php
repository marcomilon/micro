<?php 

namespace micro\test\units;

require_once __DIR__ . '/../../app/controllers/CustomCtrl.php';
require_once __DIR__ . '/../../app/modules/modulo/controllers/AppCtrl.php';

use atoum;

class Controller extends atoum
{

    public function testRender() 
    {
        $expectedRendering = dirname(__FILE__) . '/../../data/renderCustomCtrlHello.html';
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/hello'
                ];
                $app->run($queryString);
            }
        )->isEqualToContentsOfFile($expectedRendering);
    }
    
    public function testRenderWithArguments() 
    {
        $expectedRendering = dirname(__FILE__) . '/../../data/renderCustomCtrlArguments.html';
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/arguments',
                    'arg1' => 'arg1',
                    'arg2' => 'arg2'
                ];
                $app->run($queryString);
            }
        )->isEqualToContentsOfFile($expectedRendering);
    }
    
    public function testRenderViewNotFound() 
    {
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/viewnotfound'
                ];
                $app->run($queryString);
            }
        )->contains("The view file does not exist");
    }
    
    public function testRenderMissingArguments() 
    {
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'custom/arguments',
                    'arg1' => 'arg1'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Bad request");
    }
    
    public function testController() 
    {
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'modulo/app/index'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Hello modulo");
    }
    
    public function testModuloRender() 
    {
        $expectedRendering = dirname(__FILE__) . '/../../data/renderModuloAppCtrlIndex.html';
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'modulo/app/hello'
                ];
                $app->run($queryString);
            }
        )->isEqualToContentsOfFile($expectedRendering);
    }
    
    public function testModuloRenderWithArguments() 
    {
        $expectedRendering = dirname(__FILE__) . '/../../data/renderModuloAppCtrlArguments.html';
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'modulo/app/action',
                    'arg1' => 'arg1',
                    'arg2' => 'arg2'
                ];
                $app->run($queryString);
            }
        )->isEqualToContentsOfFile($expectedRendering);
    }
    
    public function testModuloRenderMissingArguments() 
    {
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'modulo/app/action',
                    'arg1' => 'arg1'
                ];
                $app->run($queryString);
            }
        )->isEqualTo("Bad request");
    }
    
    public function testModuloRenderViewNotFound() 
    {
        $app = new \micro\Application();
        $this->output(
            function() use($app) {
                $queryString = [
                    'r' => 'modulo/app/viewnotfound'
                ];
                $app->run($queryString);
            }
        )->contains("The view file does not exist");
    }
}
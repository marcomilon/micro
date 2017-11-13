<?php 

namespace micro\test\units;

require_once __DIR__ . '/../../app/controllers/CustomCtrl.php';

use atoum;

class Application extends atoum
{
    public function testLoadLayouts() {
        $this->when(
            function() {
                $ctrl = new \app\controller\CustomCtrl();    
                $ctrl->loadLayout();
            }
        )->error()->notExists();
    }
}
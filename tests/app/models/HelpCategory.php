<?php 

namespace app\models;

use micro\Application;
use micro\Model;

class HelpCategory extends Model {
    
    public static function tableName() 
    {
        return 'help_category';
    }
    
    public static function dbConnection() 
    {
        $config = self::getConfig();
        $db = $config['db'];
        
        return new \micro\db\Connection($db['servername'], $db['username'], $db['password'], $db['database']);
    }
}
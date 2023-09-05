<?php
require_once('database.php');

class UserLevelDB {
    public static function getLevels() {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = 'SELECT * FROM user_levels';
        
            return $dbConn->query($query);
        } else {
            return false;
        }
    }
}
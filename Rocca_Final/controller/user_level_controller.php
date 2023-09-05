<?php 
include_once('user_level.php');
include_once('../model/user_level_db.php');

class UserLevelController {
    public static function getAllLevels() {
        $queryRes = UserLevelDB::getLevels();

        if ($queryRes) {
            
            $levels = array();
            foreach($queryRes as $row) {
                $levels[] = new UserLevel($row['UserLevelNo'],
                    $row['LevelName']);
            }

            return $levels;
        } else {
            return false;
        }
    }
}
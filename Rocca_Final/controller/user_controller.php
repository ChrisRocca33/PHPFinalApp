<?php
include_once('user.php');
include_once('model/user_db.php');

class UserController {
    //helper function to convert a db row into a
    //User object
    private static function rowToUsers($row) {
        $user1 = new User($row['UserId'],
            $row['Password'],
            $row['FirstName'], 
            $row['LastName'],
            $row['HireDate'],
            $row['EMail'],
            $row['Extension'],
            $row['UserLevelNo'],
            $row['UserNo']);
        return $user1;
    }

    //function to check login credentials - return true
    //if user is valid, false otherwise
    public static function validUser($email, $password) {
        $queryRes = UsersDB::getUserByEMail($email);

        if ($queryRes) {
            //proccess the user row
            $user1 = self::rowToUsers($queryRes);
            if ($user1->getPassword() === $password) {
                return $user1->getUserLevel();
            } else {
                return false;
            }
        } else {
            //either no such user or db connect failed -
            //either way, cant validate the user
            return false;
        }
    }
}
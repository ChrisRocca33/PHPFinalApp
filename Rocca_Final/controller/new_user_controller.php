<?php
include_once('user.php');
include_once('../model/user_db.php');

class NewUserController {
    private static function rowToUser($row) {
        $user = new User($row['UserId'],
            $row['Password'],
            $row['FirstName'], 
            $row['LastName'],
            $row['HireDate'],
            $row['EMail'],
            $row['Extension'],
            new UserLevel($row['UserLevelNo'],
                $row['LevelName']));
            $user->setUserNo($row['UserNo']);
        return $user;
    }

    //Function to get all users
    public static function getAllUsers() {
        $queryRes = UsersDB::getUsers();

        if($queryRes) {
            $users = array();

            foreach($queryRes as $row) {
                $users[] = self::rowToUser($row);
            }

            return $users;
        } else {
            return false;
        }
    }
    //get users at a certain level
    public static function getUsersByLevel($UserLevelNo) {
        $queryRes = UsersDB::getUsersByLevel($UserLevelNo);

        if($queryRes) {
            $users = array();

            foreach($queryRes as $row) {
                $users[] = self::rowToUser($row);
            }

            return $users;
        } else {
            return false;
        }
    }

    //function to get a user by thier UserNo
    public static function getUserByNo($userNo) {
        $queryRes = UsersDB::getUser($userNo);

        if($queryRes) {
            return self::rowToUser($queryRes);
        } else {
            return false;
        }
    }

    //function to delete a user
    public static function deleteUser($userNo) {
        return UsersDB::deleteUser($userNo);
    }

    //function to add user
    public static function addUser($user) {
        return UsersDB::addUser(
            $user->getUserId(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getDate(),
            $user->getEMail(),
            $user->getExtension(),
            $user->getUserLevel()->getUserLevelNo());
    }
    //function to update user
    public static function updateUser($user) {
        return UsersDB::updateUser(
            $user->getUserNo(),
            $user->getUserId(),
            $user->getPassword(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getDate(),
            $user->getEMail(),
            $user->getExtension(),
            $user->getUserLevel()->getUserLevelNo());
    }
}
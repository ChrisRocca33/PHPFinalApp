<?php
require_once('database.php');

//class for users table queries
class UsersDB {
    //function to get a user by thier email address
    public static function getUserByEMail($email) {
        //get DB connection
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            //create the querry string
            $query = "SELECT * FROM users
                    WHERE users.EMail = '$email'";

            //execute the query - return false if
            //no such email found
            $result = $dbConn->query($query);
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    //get all users
    public static function getUsers() {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = 'SELECT * FROM users
                INNER JOIN user_levels
                ON users.UserLevelNo = user_levels.UserLevelNo';
            
            return $dbConn->query($query);
        } else {
            return false;
        }
    }
    //get all users in at a specific level
    public static function getUsersByLevel($userLevelNo) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "SELECT * FROM users
                INNER JOIN user_levels
                ON users.UserLevelNo = user_levels.UserLevelNo
                WHERE users.UserLevelNo = '$userLevelNo'";
            
            return $dbConn->query($query);
        } else {
            return false;
        }
    }
    //get users by thier userNo
    public static function getUser($userNo) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "SELECT * FROM users
                INNER JOIN user_levels
                ON users.UserLevelNo = user_levels.UserLevelNo
                WHERE UserNo = '$userNo'";
            
            $result = $dbConn->query($query);
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
    //function to delete users
    public static function deleteUser($userNo) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "DELETE FROM users
                WHERE UserNo = '$userNo'";
            
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }
    //functio to add users
    public static function addUser($id, $pw, $fName, $lName, $date, $email, $ext, $userLevelNo) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = "INSERT INTO  users (UserId, Password, FirstName, Lastname,
                HireDate, EMail, Extension, UserLevelNo)
                VALUES ('$id', '$pw', '$fName', '$lName', '$date', '$email', '$ext', '$userLevelNo')";
            
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }

    //function to update user
    public static function updateUser($uNo, $id, $pw, $fName, $lName, $date, $email, $ext, $userLevelNo) {
        $db = new Database();
        $dbConn = $db->getDbConn();

        if ($dbConn) {
            $query = 
            "UPDATE users SET
                UserId = '$id',
                Password = '$pw',
                FirstName = '$fName',
                LastName = '$lName',
                HireDate = '$date',
                EMail = '$email',
                Extension = '$ext',
                UserLevelNo = '$userLevelNo'
            WHERE UserNo = '$uNo'";
            
            return $dbConn->query($query) === TRUE;
        } else {
            return false;
        }
    }
}
<?php
//helper fuctions for dealing with security
class Security {
    public static function checkHTTPS() {
        //if not HTTPS, post a message and exit
        if (!isset($_SERVER['HTTPS'])
            || $_SERVER['HTTPS'] != 'on') {
                
            //for demonstration - normally just
            //redirect to your https://url
            echo "<h1>HTTPS is Required!</h1>";
            exit();
        }     
    }

    //perform any needed cleanup for logging out
    public static function logout() {
        //clear the session info
        session_destroy();
        session_start();

        //clear any post info to prevent back button
        //from allowing user to breach security
        $_POST = array();

        //set a logout message and return to login page
        $_SESSION['logout_msg'] = 'Succuessfully logged out.';
        header("Location: ../index.php");
        exit();
    }

    public static function checkAuthority($auth) {
        //check to see if user is authorized - if not, set
        //a message and return to login page
        if (!isset($_SESSION[$auth]) || !$_SESSION[$auth]) {
            $_SESSION['logout_msg'] = 
                'Current login unauthorized for this page.';
            header("Location: ../index.php");
            exit();
        }
    }
}
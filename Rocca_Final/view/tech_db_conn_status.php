<?php
require_once('../model/database.php');
session_start();
require_once('../util/security.php');

//confim user is authorized for the page
Security::checkAuthority('tech');

//user clicked the logout button
if (isset($_POST['logout'])) {
    Security::logout();
}
//set error reporting to errors only
error_reporting(E_ERROR);

//create an instance of the DB class
$db = new Database();
?>

<html>

<head>
    <title>Chris Rocca Final Practical</title>
</head>

<body>
    <h1>Chris Rocca Final Practical</h1>
    <h1>Database Connection Status</h1>
    <?php if (strlen($db->getDbError())) : ?>
        <h2><?php echo $db->getDbError(); ?></h2>
        <ul>
            <li><?php echo "Database Name: " 
                . $db->getDbName(); ?></li>
            <li><?php echo "Database Host: " 
                . $db->getDbHost(); ?></li>
            <li><?php echo "Database User: " 
                . $db->getDbUser(); ?></li>
            <li><?php echo "Database User Password: " 
                . $db->getDbUserPw(); ?></li>
        </ul>
    <?php else : ?>
        <ul>
            <li><?php echo "Database Name: " 
                . $db->getDbName(); ?></li>
            <li><?php echo "Database Host: " 
                . $db->getDbHost(); ?></li>
            <li><?php echo "Database User: " 
                . $db->getDbUser(); ?></li>
            <li><?php echo "Database User Password: " 
                . $db->getDbUserPw(); ?></li>
        </ul>
        <h2><?php echo " Successfully connected to "
            . $db->getDbName(); ?></h2>
    <?php endif; ?>
    <h2><a href="../view/tech.php">
            Home</a></h2>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>
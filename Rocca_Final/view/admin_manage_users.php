<?php
require_once('../controller/user.php');
require_once('../controller/new_user_controller.php');
require_once('../controller/user_level.php');
require_once('../controller/user_level_controller.php');
session_start();
require_once('../util/security.php');

//confim user is authorized for the page
Security::checkAuthority('admin');

//user clicked the logout button
if (isset($_POST['logout'])) {
    Security::logout();
}

if (isset($_POST['update'])) {
    //update button pressed for user
    if(isset($_POST['uNoUpd'])) {
        header('Location: ./admin_add_update_user.php?uNo=' . $_POST['uNoUpd']);
    }
    unset($_POST['update']);
    unset($_POST['uNoUpd']);
}

if (isset($_POST['delete'])) {
    //delete button pressed for a user
    if(isset($_POST['uNoDel'])) {
        NewUserController::deleteUser($_POST['uNoDel']);
    }
    unset($_POST['delete']);
    unset($_POST['uNoDel']);
}
?>
<html>

<head>
    <title>Chris Rocca Wk5 Performance Assessment</title>
    <link rel="stylesheet" type="text/css" href="styles.css"/>
</head>

<body>
    <h1>Chris Rocca Wk5 Performance Asssessment</h1>
    <h1>All People List</h1>
    <h2><a href="./admin_add_update_user.php">Add User</a></h2>
    <table>
        <tr>
            <th>User Id</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Hire Date</th>
            <th>EMail Address</th>
            <th>Extension</th>
            <th>Level</th>
        </tr>
        <?php foreach(NewUserController::getAllUsers() as $user) :?>
        <tr>
            <td><?php echo $user->getUserId(); ?></td>
            <td><?php echo $user->getFirstName(); ?></td>
            <td><?php echo $user->getLastName(); ?></td>
            <td><?php echo $user->getDate(); ?></td>
            <td><?php echo $user->getEMail(); ?></td>
            <td><?php echo $user->getExtension(); ?></td>
            <td><?php echo $user->getUserLevel()->getLevelName(); ?></td>
            <td><form method="POST">
                <input type="hidden" name="uNoUpd"
                    value="<?php echo $user->getUserNo() ?>"/>
                <input type="submit" value="Update" name="update" />
            </form></td>
            <td><form method="POST">
                <input type="hidden" name="uNoDel"
                    value="<?php echo $user->getUserNo() ?>"/>
                <input type="submit" value="Delete" name="delete" />
            </form></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3><a href="../view/admin.php">Home</a></h3>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>
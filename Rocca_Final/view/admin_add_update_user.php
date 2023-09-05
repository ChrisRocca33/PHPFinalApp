<?php
require_once('../controller/user.php');
require_once('../controller/new_user_controller.php');
require_once('../controller/user_level.php');
require_once('../controller/user_level_controller.php');
require_once('../validation.php');

//declare variables and clear them
$user_id = '';
$user_pw = '';
$f_name = '';
$l_name = '';
$hire_date = '';
$e_mail = '';
$ext = '';

//declare varibles and clear them for error messages
$user_id_error = '';
$user_pw_error = '';
$f_name_error = '';
$l_name_error = '';
$hire_date_error = '';
$email_error = '';
$ext_error = '';

//Retrieve values from querry string and store in a local variable
if(isset($_POST['id']))
$user_id = $_POST['id'];
if(isset($_POST['pw']))
$user_pw = $_POST['pw'];
if(isset($_POST['fName']))
$f_name = $_POST['fName'];
if(isset($_POST['lName']))
$l_name = $_POST['lName'];
if(isset($_POST['date']))
$hire_date = $_POST['date'];
if(isset($_POST['email']))
$e_mail = $_POST['email'];
if(isset($_POST['ext']))
$ext = $_POST['ext'];

//validate the values that are entered
$user_id_error = Validation\idValid($user_id, 4);
$user_pw_error = Validation\pwValid($user_pw, 4);
$f_name_error = Validation\firstNameValid($f_name, 2);
$l_name_error = Validation\lastNameValid($l_name, 2);
$hire_date_error = Validation\dateValid($hire_date);
Validation\emailValid($e_mail, $email_error);
$ext_error = Validation\extValid($ext);

$levels = UserLevelController::getAllLevels();

$user = new User('', '', '', '', date(''), '', '', $levels[0]);

$user->setUserNo(-1);
$pageTitle = "Add a New User";

//Retrieve the contactNo from the query string amd
//use it to create a contact object for that pNo
if (isset($_GET['uNo'])) {
    $user =
        NewUserController::getUserByNo($_GET['uNo']);
    $pageTitle = "Update an Existing User";
}

if (isset($_POST['save'])) {
    $user = new User($_POST['id'], $_POST['pw'], $_POST['fName'], $_POST['lName'], 
        $_POST['date'], $_POST['email'], $_POST['ext'], $levels[$_POST['levelOption']-1]);
    $user->setUserNo($_POST['uNo']);

    if ($user->getUserNo() === '-1') {
        //add
        if(strlen($user_id_error || $user_pw_error || $f_name_error || $l_name_error ||
            $hire_date_error || $email_error || $ext_error) > 0) {
            echo "There are validation Errors";
        } else { 
            header('Location: ./admin_manage_users.php');
            NewUserController::addUser($user);
        }
    } else {
        //update
        if(strlen($user_id_error || $user_pw_error || $f_name_error || $l_name_error ||
            $hire_date_error || $email_error || $ext_error) > 0) {
            echo "There are validation Errors";
        }else { 
            header('Location: ./admin_manage_users.php');
            NewUserController::updateUser($user);
    }
}
    
}
if (isset($_POST['cancel'])) {
    //cancel button - just go back to list
    header('Location: ./admin_manage_users.php');
}
    
?>

<html>

<head>
    <title>Chris Rocca Wk5 Final Practical</title>
</head>

<body>
    <h1>Chris Rocca Wk5 Final Practical</h1>
    <h2><?php echo $pageTitle; ?></h2>
    <form method = 'POST'>
        <h3>User ID: <input type = "text" name="id"
            value="<?php echo $user->getUserId(); ?>">
            <?php if(strlen($user_id_error) > 0)
                echo "<span style='color: red;'>{$user_id_error}</span>"; ?>
        </h3>
        <h3>Password: <input type = "text" name="pw"
            value="<?php echo $user->getPassword(); ?>">
            <?php if(strlen($user_pw_error) > 0)
                echo "<span style='color: red;'>{$user_pw_error}</span>"; ?>
        </h3>
        <h3>First Name: <input type = "text" name="fName"
            value="<?php echo $user->getFirstName(); ?>">
            <?php if(strlen($f_name_error) > 0)
                echo "<span style='color: red;'>{$f_name_error}</span>"; ?>
        </h3>
        <h3>Last Name: <input type = "text" name="lName"
            value="<?php echo $user->getLastName(); ?>">
            <?php if(strlen($l_name_error) > 0)
                echo "<span style='color: red;'>{$l_name_error}</span>"; ?>
        </h3>
        <h3>Hire Date: <input type = "date" name="date"
            value="<?php echo $user->getDate(); ?>">
            <?php if(strlen($hire_date_error) > 0)
                echo "<span style='color: red;'>{$hire_date_error}</span>"; ?>
        </h3>
        <h3>E-Mail: <input type = "text" name="email"
            value="<?php echo $user->getEMail(); ?>">
            <?php if(strlen($email_error) > 0)
                echo "<span style='color: red;'>{$email_error}</span>"; ?>
        </h3>
        <h3>Extension: <input type = "text" name="ext"
            value="<?php echo $user->getExtension(); ?>">
            <?php if(strlen($ext_error) > 0)
                echo "<span style='color: red;'>{$ext_error}</span>"; ?>
        </h3>
        <h3>Level: <select name="levelOption">
            <?php foreach($levels as $userLevel) : ?>
                <option value = "<?php echo $userLevel->getUserLevelNo(); ?>"
                    <?php if ($userLevel->getUserLevelNo() ===
                        $user->getUserLevel()->getUserLevelNo()) {
                            echo 'selected'; }?>>
                <?php echo $userLevel->getLevelName(); ?></option>
            <?php endforeach ?>
        </h3>
        <input type="hidden"
            value="<?php echo $user->getUserNo(); ?>" name="uNo">
        <input type="submit" value="Save" name="save">
        <input type="submit" value="Cancel" name="cancel">
    </form>
</body>
</html>
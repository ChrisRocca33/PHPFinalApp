<?php
require_once('../util/file_utilities.php');
session_start();
require_once('../util/security.php');

//confim user is authorized for the page
Security::checkAuthority('tech');

//user clicked the logout button
if (isset($_POST['logout'])) {
    Security::logout();
}
//get logs directories in current working directory
$dir = getcwd() . "/logs/";
$viewFile = '';
$editFile = '';

//user selected to view file contents
if (isset($_POST['view'])) {
    $fName = $_POST['fileToView'];
    $viewFile = FileUtilities::GetFileContents($dir . $fName);
    $editFile = '';
}

//user is loading a file to edit
if (isset($_POST['load'])) {
    $fName = $_POST['fileToUpdate'];
    $editFile = FileUtilities::GetFileContents($dir . $fName);
    $viewFile = '';
}
//user wants to save edited file contents
if (isset($_POST['save'])) {
    $fName = $_POST['fileToUpdate'];
    $content = $_POST['editFile'];
    FileUtilities::WriteFile($dir . $fName, $content);
    $editFile = '';
    $viewFile = '';
}

//user wants to create a new file
if (isset($_POST['create'])) {
    $fName = $_POST['newFileName'];
    $content = $_POST['createFile'];
    FileUtilities::WriteFile($dir . $fName, $content);
    $editFile = '';
    $viewFile = '';
}
?>
<html>

<head>
    <title>Chris Rocca Final Practical</title>
</head>

<body>
    <h1>Chris Rocca Final Practical</h1>
    <h3>Manage Inceident Text Files</h3>
    <form method="POST">
    <ul>
        <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
        <li><?php echo $file?></li>
        <?php endforeach; ?>
    </ul>
    <h3>View Log File: <select name="fileToView">
        <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
            <option value="<?php echo $file; ?>"><?php echo $file; ?>
        </option>
        <?php endforeach; ?></select>
        <input type="submit" value="View File" name="view">
    </h3>
    <textarea id="viewFile" name="viewFile" rows="5" cols="50"
            disabled><?php echo $viewFile ?></textarea>
    <h3>Update Log File: <select name="fileToUpdate">
        <?php foreach(FileUtilities::GetFileList($dir) as $file) : ?>
            <option value="<?php echo $file; ?>"><?php echo $file; ?>
        </option>
        <?php endforeach; ?></select>
        <input type="submit" value="Load File" name="load">
        <input type="submit" value="Save" name="save">
    </h3>
    <textarea id="editFile" name="editFile" rows="5" cols="50"
            ><?php echo $editFile ?></textarea>
    <h3>Create Log File: 
        <input type="text"  name="newFileName">
        <input type="submit" value="Create" name="create">
    </h3>
    <textarea id="createFile" name="createFile" rows="5" cols="50"
            ></textarea>
    </form>
    <h2><a href="../view/tech.php">
            Home</a></h2>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>
<?php
require_once('../util/image_utilities.php');
session_start();
require_once('../util/security.php');

//confim user is authorized for the page
Security::checkAuthority('admin');

//user clicked the logout button
if (isset($_POST['logout'])) {
    Security::logout();
}
//get log directories in current working directory
$dir = getcwd() . '/images/';
$imgName = '';
//user wants to view the images for the selection
if (isset($_POST['view'])) {
    $imgName = $_POST['image_file'];
}

//user wants to view the images for the selection
if(isset($_POST['delete'])) {
    $fName = $_POST['image_file'];
    $editFile = ImageUtilities::DeleteImageFiles($dir, $fName);
    $imgName = '';
}

//user wants to upload a new file
if (isset($_POST['upload'])) {
    //Note: normally would want some error checking on file
    //size and type her; for demonstration of this ability
    //were not performing all of those checks
    $target = $dir . $_FILES['new_file']['name'];
    move_uploaded_file($_FILES['new_file']['tmp_name'],
        $target);
    ImageUtilities::ProcessImage($target);
    $imgName = '';
}
?>
<html>

<head>
    <title>Chris Rocca Final Practical</title>
</head>

<body>
    <h1>Chris Rocca Final Practical</h1>
    <form method="POST">
    <h3>Image Files: <select name="image_file">
        <?php foreach(ImageUtilities::GetBaseImagesList($dir) as $file) :?>
            <option value="<?php echo $file; ?>"><?php echo $file; ?>
        </option>
        <?php endforeach; ?></select></h3>
        <input type="submit" value="View Images" name="view">
        <input type="submit" value="Delete Image" name="delete">
    </h3>
    </form>
    <h3>Upload Image File: 
        <form method="POST" enctype="multipart/form-data">
        <input type="file" name="new_file" id="new_file">
        <input type="submit" value="Upload" name="upload">
        </form>
    </h3>
    <h4>Original Image:</h4>
    <img src="images/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <h4>200px Max Image:</h4>
    <img src="images/200/<?php echo $imgName; ?>" alt="<?php echo $imgName; ?>">
    <h2><a href="../view/admin.php">
            Home</a></h2>
    <form method='POST'>
        <input type="submit" value="Logout" name="logout">
    </form>
</body>
</html>
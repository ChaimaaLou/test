<?php
    if(isset($_POST["submit"])) { 
        include("connexion.php");
        

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Sign up</title>
</head>
<body>
<div id="content">
    <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control" type="file" name="uploadfile" value="" />
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
        </div>
    </form>
</div>

<div id="display-image">
    <?php
    // Your database connection code (e.g., $db = mysqli_connect(...);)

    if (isset($_POST['upload'])) {
        $filename = $_FILES['uploadfile']['name'];
        $tempname = $_FILES['uploadfile']['tmp_name'];
        $folder = "image/" . $filename;

        // Move uploaded file to the designated folder
        move_uploaded_file($tempname, $folder);

        // Insert filename into the database
        $query = "INSERT INTO image (filename) VALUES ('$filename')";
        mysqli_query($db, $query);
    }

    // Display images from the database
    $query = "SELECT * FROM image";
    $result = mysqli_query($db, $query);

    while ($data = mysqli_fetch_assoc($result)) {
        ?>
        <img src="./image/<?php echo $data['filename']; ?>">
        <?php
    }
    ?>
</div>

</html>

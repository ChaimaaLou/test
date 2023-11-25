<?php
include("connexion.php");
session_start();

    if (isset($_GET['recipe_id'])) {
        $_SESSION['recipe_id'] = $_GET['recipe_id'];
        echo "Recipe ID stored successfully!";
    } else {
        echo "Recipe ID not provided!";
    }


if(isset($_POST["submit"])) {
    $recipe_id = $_POST['recipe_id'];
    $recipe_name = $_POST['recipe_name'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $duration = $_POST['duration'];
    $filename = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $folder = "image/" . $filename;

    $r =$_SESSION['recipe_id'];
    move_uploaded_file($tempname, $folder);

    $stmt = $pdo->prepare("UPDATE recettes SET nom = ?, listeIngredients = ?, etapesPreparation = ?, dureePreparation = ?, photo = ? WHERE id = ?");
    $stmt->execute([$recipe_name, $ingredients, $steps, $duration,$filename, $r]);

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        echo "Recipe updated successfully!";
    } else {
        echo "Error updating recipe!";
    }
} else {
    // Fetch data for the selected recipe from the database
    if(isset($_GET['recipe_id'])) {
        $recipe_id = $_GET['recipe_id'];
        $stmt = $pdo->prepare("SELECT * FROM recettes WHERE id = ?");
        $stmt->execute([$recipe_id]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
        <h1>Sign up</h1>
        <form name="fo" method="post" action="" enctype="multipart/form-data"> 
        <label for="recipe_name">Recipe Name:</label>
        <input type="text" name="recipe_name" value="<?php echo $recipe['nom']; ?>" required>

        <label for="ingredients">Ingredients:</label>
        <textarea name="ingredients" rows="5" required><?php echo $recipe['listeIngredients']; ?></textarea>

        <label for="steps">Preparation Steps:</label>
        <textarea name="steps" rows="5" required><?php echo $recipe['etapesPreparation']; ?></textarea>

        <label for="duration">Duration:</label>
        <input type="text" name="duration" value="<?php echo $recipe['dureePreparation']; ?>" required>

        <label for="image">Image:</label>
        <input type="file" name="image" accept="image/*">

        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
        <input type="submit" value="Update Recipe" name ="submit">
        </form>
</body>
</html>


<?php
    include("connexion.php");
    session_start();

    // Check if the user is logged in
    if (isset($_SESSION['user_id'])) {
        $connectedUserId = $_SESSION['user_id'];

        // Fetch data from the recettes table for the connected user
        $stmt = $pdo->prepare("SELECT * FROM recettes WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $connectedUserId, PDO::PARAM_INT);
        $stmt->execute();
        $recettesData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        exit();
    }
  
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recettes Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <h2>Recettes Data</h2>
    
    <?php if (!empty($recettesData)): ?>
        <table class="table table-hover" style="margin: 50px; width : 90%;">
            <thead class="table-info">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Liste d'Ingrédients</th>
                    <th>Étapes de Préparation</th>
                    <th>Durée de Préparation</th>
                    <th>Photo</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recettesData as $recette): ?>
                    <tr onclick="redirectToModifyPage(<?php echo $recette['id']; ?>)">
                        <td ><?php echo $recette['id']; ?></td>
                        <td ><?php echo $recette['nom']; ?></td>
                        <td ><?php echo $recette['listeIngredients']; ?></td>
                        <td ><?php echo $recette['etapesPreparation']; ?></td>
                        <td ><?php echo $recette['dureePreparation']; ?></td>
                        <td><img src="./image/<?php echo $recette['photo']; ?>" style ="height : 50px;"></td>
                    
                        <td>
                            <form method="post" action="delete.php">
                                <input type="hidden" name="recipe_id" value="<?php echo $recette['id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <script>
            function redirectToModifyPage(recipeId) {
                // Store the recipe ID in a session variable
                sessionStorage.setItem('selectedRecipeId', recipeId);

                // Redirect to modify.php with the recipe ID as a query parameter
                window.location.href = 'modify.php?recipe_id=' + recipeId;
            }
        </script>


    <?php else: ?>
        <p>No data available in the recettes table.</p>
    <?php endif; ?>
</body>
</html>
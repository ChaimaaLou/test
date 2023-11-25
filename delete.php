include("connexion.php");
$stmt = $conn->prepare("DELETE FROM recettes WHERE id = :rowId");
    $stmt->bindParam(':rowId', $rowIdToDelete, PDO::PARAM_INT);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->rowCount() > 0) {
        echo "Row deleted successfully!";
    } else {
        echo "No rows deleted. Row with ID $rowIdToDelete not found.";
    }

    // Close the connection
    $conn = null;
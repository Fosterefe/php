<?php
require_once("../db.php");

if (isset($_POST['newTitle'])) {
    $conn = connectDb();

    $book_id = mysqli_real_escape_string($conn, $_POST['id']);
    $new_title = mysqli_real_escape_string($conn, $_POST['newTitle']);

    $query = "UPDATE books SET title = '$new_title' WHERE id = $book_id";
    if ($conn->query($query) === TRUE) {
        echo "Book title updated successfully.";
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error updating book title: " . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library</title>
    <link rel="stylesheet" href="../styles/styles.css" />
</head>

<body>
    <h1>Editando libro</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?= $_POST['id'] ?>">

        <label>Ingresa el nuevo título del libro</label>
        <input type="text" name="newTitle" value="<?= $_POST['title'] ?>" required />

        <button type="submit">Actualizar</button>
    </form>
</body>

</html>
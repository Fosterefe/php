<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library system</title>
    <link rel="stylesheet" href="../styles/styles.css" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/bookList.css" />
    <link rel="stylesheet" href="../styles/addBook.css" />
    <link rel="stylesheet" href="../styles/authors.css" />
    <link rel="stylesheet" href="../styles/manageLibrary.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<?php
require_once "../db.php";
$conn = connectDb();
$authorId = $_POST['id'];
$authorName = get_author_name($conn, $authorId);

if (isset($_POST['newName'])) {
    $new_name = $_POST['newName'];
    update_author_name($conn, $new_name, $authorId);
    header("Location: ../authors.php");
    exit;
}

function get_author_name($conn, $id)
{
    $query = "SELECT * FROM authors WHERE id = $id;";
    $res = $conn->query($query);
    $row = $res->fetch_assoc();
    return $row['name'];
}

function update_author_name($conn, $name, $id)
{
    $query = "UPDATE authors SET name = '$name' WHERE id = $id";
    $res = $conn->query($query);
    return $res;
}
?>

<body>
    <div class="container">
        <?php require("../includes/navbar.php") ?>
        <div class="manageLibrary">
            <h1>Editando autor</h1>
            <form class="updateForm" action="" method="post">
                <label>Ingresa un nuevo nombre:</label>
                <input type="text" name="newName" required value="<?= $authorName ?>" />
                <input type="hidden" name="id" required value="<?= $_POST['id'] ?>" />

                <button type="submit" class="actionBtn updateBtn">Actualizar</button>
            </form>
        </div>
    </div>
</body>

</html>
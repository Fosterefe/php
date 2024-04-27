<?php include "./includes/header.php" ?>

<?php
require("./db.php");
$conn = connectDb();

$query = "SELECT * FROM authors;";
$res = $conn->query($query);

$id = $_POST['id'];

if (isset($id)) {
    $deleteAuthorQuery = "DELETE FROM authors WHERE id = $id;";
    $deleteAuthorFromBook = "UPDATE books SET authorId = NULL WHERE authorId = $id";

    $delete_books = $conn->query($deleteAuthorFromBook);
    $delete_author = $conn->query($deleteAuthorQuery);

    if ($delete_author) {
        header("Location: ./authors.php");
        exit;
    } else {
        echo "Something happended";
    }
}
?>

<body>
    <div class="container">
        <?php include "./includes/navbar.php" ?>
        <div class="autores">
            <h1>Autores</h1>
            <ul>
                <?php
                if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                ?>
                        <li class="autor">
                            <p><?= $row["name"] ?></p>
                            <div class="authorsActions">
                                <form class="autor-delete" method="post" action="">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                    <button class="actionBtn deleteBtn" type="submit">Eliminar</button>
                                </form>
                                <form class="autor-delete" method="post" action="./queries/update_author.php">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>" />
                                    <input type="hidden" name="name" value="<?= $row['name'] ?>" />
                                    <button class="actionBtn updateBtn" type="submit">Actualizar</button>
                                </form>
                                <a href="./index.php?authorFilter=<?= $row['id'] ?>">
                                    <button class="actionBtn updateBtn">Libros</button>
                                </a>
                            </div>
                        </li>
                    <?php } ?>
                <?php
                } else {
                    echo "No hay autores!";
                }
                ?>
            </ul>

        </div>

    </div>
</body>

</html>
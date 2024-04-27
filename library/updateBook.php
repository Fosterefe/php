<?php include "./includes/header.php" ?>

<?php
require_once("./db.php");
$conn = connectDb();

if (isset($_POST['newTitle']) && isset($_POST['newAuthor'])) {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $new_title = trim(htmlspecialchars($_POST['newTitle']));
    $new_name = trim(htmlspecialchars($_POST['newAuthor']));

    if (empty($new_title) || empty($new_name)) {
        echo "Fill all the inputs!";
        header("Location: ./updateBook.php");
        exit;
    }

    $authorId = get_author_id($conn, $book_id);
    $newAuthor = "";

    if ($authorId) {
        $more_authors = count_authors($conn, $new_name);
        if ($more_authors) {
            $getAuthorId = "SELECT * FROM authors WHERE authors.name = '$new_name';";
            $res = $conn->query($getAuthorId);
            $id = $res->fetch_assoc()['id'];
            attach_author_to_book($conn, $id, $book_id);
        } else {
            change_author($conn, $new_name, $book_id);
        }
    } else {
        $searchAutorQuery = "SELECT COUNT(name) FROM authors WHERE name = '$new_name'";
        if ($conn->query($searchAutorQuery)->fetch_assoc()["COUNT(name)"] == 0) {
            $newAuthor = "INSERT INTO authors (name) VALUES ('$new_name')";
            $res = $conn->query($newAuthor);
            echo "author had to be created <br />";
        }

        $getAuthorId = "SELECT * FROM authors WHERE authors.name = '$new_name';";
        $res = $conn->query($getAuthorId);
        $id = $res->fetch_assoc()['id'];
        $attachAuthorToBook = "UPDATE books SET authorId = $id WHERE books.id = $book_id;";
        $conn->query($attachAuthorToBook);
    }

    $newTitle = "UPDATE books SET title = '$new_title' WHERE books.id = $book_id;";
    $conn->query($newTitle);

    header("Location: ../index.php");
    exit;
}

function attach_author_to_book($conn, $id, $book_id)
{
    $attachAuthorToBook = "UPDATE books SET authorId = $id WHERE books.id = $book_id;";
    $conn->query($attachAuthorToBook);
}

function get_author_id($conn, $book_id)
{
    $book_query = "SELECT * FROM books WHERE books.id = $book_id";
    $res = $conn->query($book_query);
    $authorId = $res->fetch_assoc()['authorId'];
    return $authorId;
}

function count_authors($conn, $new_name)
{
    $searchAutorQuery = "SELECT COUNT(name) FROM authors WHERE name = '$new_name'";
    $res = $conn->query($searchAutorQuery);
    $row = $res->fetch_assoc()["COUNT(name)"];
    return $row > 0;
}

function change_author($conn, $new_name, $book_id)
{
    $create_new_author = "INSERT INTO authors(name) VALUES ('$new_name')";
    $conn->query($create_new_author);

    $get_author = "SELECT * FROM authors WHERE name = '$new_name'";
    $res = $conn->query($get_author);
    $row = $res->fetch_assoc()['id'];
    $change_author = "UPDATE books SET authorId = $row WHERE books.id = $book_id;";
    $conn->query($change_author);
}
?>

<body>
    <div class="container">
        <?php require("./includes/navbar.php") ?>
        <div class="manageLibrary">
            <h1>Editando libro</h1>
            <form class="updateForm" action="" method="post">
                <input type="hidden" name="book_id" value="<?= $_POST['bookId'] ?>" required />

                <label>Ingresa el nuevo título del libro</label>
                <input type="text" name="newTitle" value="<?= $_POST['title'] ?>" required />

                <label>Cambiar autor</label>
                <input type="text" name="newAuthor" value="<?= $_POST['authorName'] ?>" required />

                <button type="submit" class="actionBtn updateBtn">Actualizar</button>
            </form>
        </div>
    </div>
</body>

</html>
<?php
require_once("../db.php");

$book_id = intval($_POST['bookId']);
$conn = connectDb();

if (isset($book_id)) {
    $delete_query = "DELETE FROM books WHERE id = $book_id;";
    $conn->query($delete_query);
    header("Location: ../index.php");
    exit;
} else {
    echo "Error";
}

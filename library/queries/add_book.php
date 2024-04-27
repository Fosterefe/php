<?php
require_once("../db.php");

$title = trim(htmlspecialchars($_POST['title']));
$author = trim(htmlspecialchars($_POST['author']));
$category = $_POST['category'];

if (empty($title) || empty($author) || empty($category)) {
    echo "Titulo y nombre de autor no puden estar vacios!";
    header("Location: ../index.php");
    exit;
}

$conn = connectDb();

$query = "SELECT id FROM authors WHERE name = '$author'";
$res = $conn->query($query);

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $authorId = $row['id'];
} else {
    $createAuthorQuery = "INSERT INTO authors(name) VALUES ('$author');";
    $conn->query($createAuthorQuery);
    $authorId = $conn->insert_id;
}

$createBookQuery = "INSERT INTO books(title, authorId, category) VALUES ('$title', $authorId, '$category');";
$conn->query($createBookQuery);

$conn->close();

header("Location: ../index.php");
exit;

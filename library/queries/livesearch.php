<?php

include("../db.php");
$conn = connectDb();
if (isset($_POST['input'])) {
    $input = $_POST['input'];
    $query = "SELECT * FROM authors WHERE name LIKE '{$input}%'";
    $res = $conn->query($query);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
?>
            <div class="authorList">
                <li class="authorItem">
                    <p class="name"><?= $row['name']; ?></p>
                    <p class="id" style="display: none;"><?= $row['id'] ?></p>
                </li>
            </div>
<?php
        }
    }
}

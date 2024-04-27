<?php include "./includes/header.php" ?>
<?php
require("./db.php");
$conn = connectDb();
?>

<body>
   <div class="container">
      <?php include "./includes/navbar.php" ?>
      <div class="books">
         <h1>Lista de libros</h1>
         <br />
         <form class="filterForm" action="" method="get">
            <h4>Categorias:</h4>
            <?php
            $categories = ["Romance", "Comedia", "Horror", "Ciencia Ficción", "Aventura"];
            foreach ($categories as $category) {
               $checked = [];
               if (isset($_GET['categoryFilter'])) {
                  $checked = $_GET['categoryFilter'];
               }
            ?>
               <div class="categoryForm">
                  <label><?= $category ?></label>
                  <input style="width: auto;" type="checkbox" name="categoryFilter[]" value="<?= $category ?>" <?php
                                                                                                               if (in_array($category, $checked)) {
                                                                                                                  echo "checked";
                                                                                                               }
                                                                                                               ?> />
               </div>
            <?php
            }
            ?>
            <button class="actionBtn submit" type="submit">Filtrar</button>
         </form>

         <form class="filterFormAuthor" action="" method="get" style="margin-bottom: 10px;">
            <h4>Por autor:</h4>
            <div class="categoryFormAuthor">
               <input type="text" id="inputNameCb" autocomplete="off" />
               <input type="hidden" id="idAuthor" name="authorFilter" autocomplete="off" />
               <button class="actionBtn submit" type="submit">Filtrar</button>
            </div>
            <div id="searchResult" style="display: flex; flex-direction: row; flex-wrap: wrap; gap: 10px; ">
            </div>
         </form>
         <ul>
            <?php
            $filters = [];
            $isAuthor = false;
            $query;

            if (isset($_GET['authorFilter'])) {
               $id = $_GET['authorFilter'];
               array_push($filters, $id);
               $query = "SELECT books.title, books.authorId ,books.id as bookId, books.category, authors.name FROM books INNER JOIN authors ON books.authorId = authors.id WHERE";
               $isAuthor = true;
            } else if (isset($_GET['categoryFilter'])) {
               $filters = $_GET['categoryFilter'];
               $query = "SELECT books.title, books.authorId, books.id as bookId, books.category, authors.name FROM books LEFT JOIN authors ON books.authorId = authors.id WHERE";
            }

            if (count($filters) > 0) {
               foreach ($filters as $filter) {
                  $temp = $query;
                  $temp = $isAuthor ? $temp . " books.authorId = $filter;" : $temp . " books.category = '$filter';";
                  $res = $conn->query($temp);

                  if ($res->num_rows > 0) {
                     while ($row = $res->fetch_assoc()) {
            ?>
                        <li class="book-element">
                           <div class="book">
                              <div class="book-info">
                                 <div class="inf">
                                    <h3 class="title"><?= $row['title'] ?></h3>
                                    <?php
                                    if ($row['name']) {
                                    ?>
                                       <p class="author"><?= "By " . $row['name'] ?></p>
                                    <?php
                                    } else {
                                       echo "Autor desconocido";
                                    }
                                    ?>
                                 </div>
                                 <div class="category">
                                    <h3><?= $row['category'] ?></h3>
                                    <div class="bookActions">
                                       <form method="post" action="./queries/delete_book.php">
                                          <input type="hidden" name="bookId" value="<?= $row['bookId'] ?>" />
                                          <button class="actionBtn deleteBtn" type="submit">Eliminar</button>
                                       </form>
                                       <form method="post" action="./updateBook.php">
                                          <input type="hidden" name="bookId" value="<?= $row['bookId'] ?>" />
                                          <?php
                                          if ($row['authorId']) {
                                          ?>
                                             <input type="hidden" name="authorName" value="<?= $row['name'] ?>" />
                                          <?php
                                          } else {
                                          ?>
                                             <input type="hidden" name="authorName" value="" />
                                          <?php
                                          }
                                          ?>
                                          <input type="hidden" name="title" value="<?= $row['title'] ?>" />
                                          <button class="actionBtn updateBtn" type="submit">Actualizar</button>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </li>
                     <?php
                     }
                  }
               }
            } else {
               $query = "SELECT books.title, books.authorId ,books.id as bookId, books.category, authors.name FROM books LEFT JOIN authors ON books.authorId = authors.id;";
               $res = $conn->query($query);
               if ($res->num_rows > 0) {
                  while ($row = $res->fetch_assoc()) {
                     ?>
                     <li class="book-element">
                        <div class="book">
                           <div class="book-info">
                              <div class="inf">
                                 <h3 class="title"><?= $row['title'] ?></h3>
                                 <?php
                                 if ($row['name']) {
                                 ?>
                                    <p class="author"><?= "By " . $row['name'] ?></p>
                                 <?php
                                 } else {
                                    echo "Autor desconocido";
                                 }
                                 ?>
                              </div>
                              <div class="category">
                                 <h3><?= $row['category'] ?></h3>
                                 <div class="bookActions">
                                    <form method="post" action="./queries/delete_book.php">
                                       <input type="hidden" name="bookId" value="<?= $row['bookId'] ?>" />
                                       <button class="actionBtn deleteBtn" type="submit">Eliminar</button>
                                    </form>
                                    <form method="post" action="./updateBook.php">
                                       <input type="hidden" name="bookId" value="<?= $row['bookId'] ?>" />
                                       <?php
                                       if ($row['authorId']) {
                                       ?>
                                          <input type="hidden" name="authorName" value="<?= $row['name'] ?>" />
                                       <?php
                                       } else {
                                       ?>
                                          <input type="hidden" name="authorName" value="" />
                                       <?php
                                       }
                                       ?>
                                       <input type="hidden" name="title" value="<?= $row['title'] ?>" />
                                       <button class="actionBtn updateBtn" type="submit">Actualizar</button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </li>
               <?php
                  }
               } else {
                  echo "No hay libros";
               }
               ?>
            <?php
            }
            ?>
         </ul>
      </div>
   </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
   $(document).ready(function() {
      $("#inputNameCb").keyup(function() {
         var input = $(this).val();
         if (input != '') {
            $.ajax({
               url: "./queries/livesearch.php",
               method: "POST",
               data: {
                  input: input,
               },
               success: function(data) {
                  $("#searchResult").html(data);
               }
            })
         } else {
            $("searchResult").css("display", "none");
         }
      })
      $("#searchResult").on("click", '.authorList', 'authorItem', function() {
         $("#inputNameCb").val($(this).find('p.name').text());
         $("#idAuthor").val($(this).find('p.id').text());
         $("#searchResult").empty();
      })
   })
</script>

</html>
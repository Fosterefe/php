<?php require("./includes/header.php") ?>

<body>
    <div class="container">
        <?php require("./includes/navbar.php") ?>

        <div class="addBooks">
            <h1>Añadir libros</h1>
            <form class="addBookForm" action="./queries/add_book.php" method="post">
                <div class="inputField">
                    <label>Título:</label> <br />
                    <input type="text" name="title" required />
                </div>

                <div class="inputField">
                    <label>Autor:</label> <br />
                    <input type="text" id="inputNameCb" name="author" autocomplete="off" required />

                    <div id="searchResult">
                    </div>
                </div>

                <div class="inputField">
                    <label for="pet-select">Categoria:</label>
                    <select name="category" id="category" required>
                        <option value="">--Elije una categoria--</option>
                        <option value="Romance">Romance</option>
                        <option value="Comedia">Comedia</option>
                        <option value="Horror">Horror</option>
                        <option value="Policiaca">Policiaca</option>
                        <option value="Ciencia Ficción">Ciencia Ficción</option>
                        <option value="Aventura">Aventura</option>
                    </select>
                </div>

                <button class="addBookBtn" type="submit">Añadir libro</button>
            </form>
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
            $("#searchResult").empty();
        })
    })
</script>

</html>
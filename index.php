<?php
require_once "script.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Libreria</title>
</head>

<body>
    <h1>Gestione Libreria</h1>

    <form method="POST">
        <div class="inputs">
            <input type="text" name="titolo" placeholder="Titolo" required>
            <input type="text" name="autore" placeholder="Autore">
        </div>
        <button type="submit">Aggiungi Libro</button>
    </form>
    <div class="books-container">
        <?php include "bookCard.php" ?>
    </div>
</body>

</html>
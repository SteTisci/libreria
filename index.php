<?php
require_once "script.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Libreria</title>
</head>

<body>
    <h1>Gestione Libreria</h1>

    <form method="POST">
        <input type="text" name="titolo" placeholder="Titolo" required>
        <input type="text" name="autore" placeholder="Autore">
        <button type="submit">Aggiungi Libro</button>
    </form>

    <h2>Elenco Libri</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Titolo</th>
            <th>Autore</th>
            <th>Anno</th>
            <th>Azione</th>
        </tr>

        <?php
        $data = $database->select();

        if (!empty($data)) {
            foreach ($data as $libro):
                ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo htmlspecialchars($libro['titolo']); ?></td>
                    <td><?php echo htmlspecialchars($libro['autore']); ?></td>
                    <td><?php echo htmlspecialchars($libro['anno_pubblicazione']); ?></td>
                    <td>
                        <a href="index.php?id=<?php echo $libro['id']; ?>">Elimina</a>
                    </td>
                </tr>
            <?php endforeach;
        }
        $database->close();
        ?>
    </table>
</body>

</html>
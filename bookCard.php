<?php
$data = $database->select();

if (!empty($data)) {
    foreach ($data as $libro):
        ?>
        <div class="bookCard" style="background-image: url('<?php echo htmlspecialchars($libro['img']); ?>">
            <div class="book-info">
                <p class="id" hidden><?php echo $libro['id']; ?></p>
                <h4 class="title"><?php echo htmlspecialchars($libro['titolo']); ?></h4>
                <p class="author"><?php echo htmlspecialchars($libro['autore']); ?></p>
                <p class="anno-pubblicazione"><?php echo htmlspecialchars($libro['anno_pubblicazione']); ?></p>
                <a href="index.php?id=<?php echo $libro['id']; ?>">Elimina</a>
            </div>
        </div>
    <?php endforeach;
}
$database->close();
?>
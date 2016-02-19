<hr>
<a href="reservation.php?action=edit">Créer une réservation</a>
<hr>
<ul>
    <?php
    $messages = [];
    if (isset($_SESSION['messages'])) {
        $messages = $_SESSION['messages'];
        $_SESSION['messages'] = [];
    }
    for ($i = 0; $i < count($messages); $i++) {
        ?>
        <li>
            <?= $messages[$i]['id'] ?> / <?= $messages[$i]['name'] ?>
            <a href="reservation.php?action=edit&cours=<?= $messages[$i]['id'] ?>">Modifier</a>
        </li>
        <?php
    }
    ?>
</ul>
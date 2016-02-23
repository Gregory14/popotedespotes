<div class="container">
    <section class="overlayContainer">
    <h1>Mes popotes en cours</h1>
<a href="reservation.php?action=edit" class="btn">Créer une réservation</a>
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
            <?= $messages[$i]['id'] ?> / <?= $messages[$i]['offre'] ?>
            <a href="reservation.php?action=edit&id=<?= $messages[$i]['id'] ?>">Modifier</a>
        </li>
        <?php
    }
    ?>
</ul>
</section>
</div>
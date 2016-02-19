<hr>
<a href="devis.php?action=edit">Créer un devis</a>
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
            <?= $messages[$i]['devis'] ?> / <?= $messages[$i]['name'] ?>
            <a href="devis.php?action=edit&devis=<?= $messages[$i]['devis'] ?>">Modifier</a>
        </li>
<?php
    }
?>
</ul>
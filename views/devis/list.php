<div class="container">
    <section class="col-lg-10 col-lg-offset-1 overlayContainer">
        <div class="row">

<a href="devis.php?action=edit" class="btn">Créer un devis</a>
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

            </div></section></div>
<?php
$postdata = [];
if (isset($_SESSION['postdata'])) {
    $postdata = $_SESSION['postdata'];
    $_SESSION['postdata'] = [];
}
$errors = [];
if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    $_SESSION['errors'] = [];
}

?>
<div class="container overlayContainer">
    <div class="row">
<h1>Merci de votre réponse</h1>

<p class="col-lg-8 col-lg-offset-2">L'équipe de La Popote des potes vous remercie d'avoir répondu à cette invitation. La personnes en charge de l'organisation de l'événement reviendra vers vous lorsqu'il sera confirmé par l'ensemble des participants.</p>
<p class="col-lg-8 col-lg-offset-2"> En attendant, nous vous invitons à nous rejoindre sur les réseaux</p>

        <div class="col-lg-4 col-lg-offset-4"><a href="index.php" class="btn">Retour à la page d'accueil</a></div>
    </div>
</div>

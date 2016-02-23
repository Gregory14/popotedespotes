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
if (DEBUG) {

    echo('<pre>$errors ');
    print_r($errors);
    echo("</pre>");

    echo('<pre>$postdata ');
    print_r($postdata);
    echo("</pre>");

}
?>

<div class="container">
    <section class="col-lg-10 col-lg-offset-1 overlayContainer">
        <div class="row">
<h1>Merci pour votre commande</h1>
<p class="col-lg-8 col-lg-offset-2">Votre demande a bien été enregistré, et l'équipe de La Popote des Potes est ravie de vous compter parmi ceux qui croient en notre action.
Nous sommes impatient de partager un moment de cuisine solidaire avec vous. En attendant, vous trouverez ci-dessous un récapitulatif de votre commande.</p>
</div>
<div>
    <a href="download.php" class="btn">Télécharger le devis</a>
</div>

<section id="firmInfos">
    <h3>Information de votre compte</h3>
    <div>
        <h4>Information de l'entreprise</h4>
        <ul>
            <li>Nom de l'entreprise : <?php echo ($postdata['entreprise']);?></li>
            <li>N° de SIRET : <?php echo ($postdata['siret']);?></li>
            <li>Adresse : <?php echo ($postdata['adresse']);?></li>
            <li>Code postal : <?php echo ($postdata['cp']);?></li>
            <li>Ville : <?php echo ($postdata['ville']);?></li>
        </ul>
    </div>
    <div>
        <h4>Contact</h4>
        <ul>
            <li>Nom : <?php echo ($postdata['entreprise']);?></li>
            <li>Prénom : <?php echo ($postdata['prenom']);?></li>
            <li>email : <?php echo ($postdata['email']);?></li>
            <li>Téléphone fixe : <?php echo ($postdata['fixe']);?></li>
            <li>Portable : <?php echo ($postdata['mobile']);?></li>
        </ul>
    </div>
</section>

<div>
    <h3>Recapitulatif de votre commande N° <?php echo $postdata['devis'];?></h3>
    <table class="table table-responsives">
        <tr>
            <td>Participants</td>
            <td>Types de plats</td>
            <td>Cuisine</td>
            <td>Lieu</td>
            <td>Date</td>
            <td>Bénéficiaire</td>
        </tr>
        <tr>
            <td><?php echo ($postdata['offre']);?></td>
            <td><?php if (isset($postdata['menu']) && !empty($postdata['menu'])) {echo ($postdata['menu']);} else {echo "En attente des réponses collaborateur";}?></td>
            <td><?php if (isset($postdata['type_cuisine']) && !empty($postdata['type_cuisine'])) {echo ($postdata['type_cuisine']);} else {echo "En attente des réponses collaborateur";}?></td>
            <td><?php echo ($postdata['lieu']);?></td>
            <td><?php echo ($postdata['date']);?></td>
            <td><?php if (isset($postdata['association']) && !empty($postdata['association'])) {echo $postdata['association'];} else {echo "En attente des réponses collaborateur";}?></td>
        </tr>
    </table>
    <div>
        <?php
        $startPrice = 150;
        $prixHT;
        $nbr_participant;
        $max_participant = intval($postdata['offre']);
        if ($max_participant == 0 OR $max_participant < 0){
            $prixHT = 'Une erreur s\'est produite. Merci de nous contacter';
        }
        elseif ($max_participant > 0 AND $max_participant < 11){
            $prixHT = $startPrice;
        }
        elseif ($max_participant > 10 AND $max_participant < 21){
            $prixHT = $startPrice * 2;
        }
        elseif ($max_participant > 20 AND $max_participant < 31){
            $prixHT = $startPrice * 3;
        }
        else{
            $prixHT = $startPrice * 4;
        }
        ?>
        <p>Prix HT : <?php echo ($prixHT);?></p>
    </div>

    <div>
        <p><a href="<?php echo 'mon-cours.php?action=edit&id='.$postdata['id'];?>">Partager le lien</a></p>
    </div>
</div>

<div>
    <h3>Suivez-nous</h3>
    <?php include 'views/partials/socialLinks.php';?>

</div>
        </div>
        </section>
    </div>
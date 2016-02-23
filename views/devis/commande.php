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
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur non lectus imperdiet, facilisis magna porttitor, vulputate magna. Nam sodales, orci et finibus dapibus, purus nisi sodales nunc, nec porttitor purus nibh at dui. Nunc suscipit, eros quis egestas vestibulum, massa dolor euismod neque, at tincidunt erat nunc et nulla. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

<div>
    <a href="download.php" class="btn">Télécharger le devis</a>
</div>

<div>
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
        <h3>Contact</h3>
        <ul>
            <li>Nom : <?php echo ($postdata['entreprise']);?></li>
            <li>Prénom : <?php echo ($postdata['prenom']);?></li>
            <li>email : <?php echo ($postdata['email']);?></li>
            <li>Téléphone fixe : <?php echo ($postdata['fixe']);?></li>
            <li>Portable : <?php echo ($postdata['mobile']);?></li>
        </ul>
    </div>
</div>

<div>
    <h2>Recapitulatif de votre commande N° <?php echo $postdata['devis'];?></h2>
    <table>
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
            <td><?php echo ($postdata['menu']);?></td>
            <td><?php echo ($postdata['type_cuisine']);?></td>
            <td><?php echo ($postdata['lieu']);?></td>
            <td><?php echo ($postdata['date']);?></td>
            <td><?php echo ($postdata['association']);?></td>
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
        } var_dump($max_participant);
        ?>
        <p>Prix HT : <?php echo ($prixHT);?></p>
    </div>
</div>

<div>
    <h2>Suivez-nous</h2>
    <ul>
        <li>Linkedin</li>
        <li>facebook</li>
        <li>twitter</li>
    </ul>
</div>
        </div>
        </section>
    </div>
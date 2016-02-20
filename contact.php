<?php
//config
include('includes/config.inc.php');

// connection base mysql
include('includes/database.inc.php');

//demarrage session
session_start();


function render($view){
    include('views/layout/header.php');
    include('views/'. $view);
    include('views/layout/footer.php');
}


if (DEBUG) {

    echo('<pre>$_GET ');
    print_r($_GET);
    echo("</pre>");

    echo('<pre>$_POST ');
    print_r($_POST);
    echo("</pre>");

    echo('<pre>$_FILES ');
    print_r($_FILES);
    echo("</pre>");

}


//----------------------------------------------------------------------------------------------------------------------
/* LOGIQUE DU CONTROLLER */

/* valeurs par defaut dans la session */
// liste des messages
$_SESSION['messages'] = [];
// données pour formulaire
$_SESSION['postdata'] = [];
// liste des erreurs
$_SESSION['errors'] = [];


// si une action est demandée
if (isset($_GET['action'])){
    // demande de verification ajax
    if ($_GET['action'] == "check") {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $states = array('errors' => checkFields($_POST, $_FILES));
            header('Content-type: application/json');
            echo(json_encode($states, JSON_FORCE_OBJECT));
        }
    //Confirmation commande
    }else if ($_GET['action'] == 'commande'){
        if (isset($_GET['devis'])&&isset($_GET['id'])){
            // recherche dans la table devis les elements avec devis = "$_GET['devis']"
            $sql = "select * from devis, cours where devis.devis =:devis and cours.id =:id limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':devis' => $_GET['devis'],
                ':id' => $_GET['id']
            ));
            $message = $sth -> fetch();
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $message;
        }
        render('devis/commande.php');

    // demande d'edition
    }else if ($_GET['action'] == "edit"){
        // est ce qu'on m'a fourni un id ?
        if (isset($_GET['devis'])){
            // recherche dans la table cours les elements avec id = "$_GET['id']"
            $sql = "select * from devis where devis =:devis limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':devis' => $_GET['devis']
            ));
            $message = $sth -> fetch();
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $message;
        }
        render('devis/form.php');

    // demande de sauvegarde de données saisies dans le form
    }else if ($_GET['action'] == "save"){
        // verification des champs, ne traite que les champs fournis
        $errors = checkFields($_POST/*, $_FILES*/);

        // redirection si aucune erreur remontée
        if (count($errors) == 0) {


            /* syntaxe avec preparedStatements */
            $sql = "insert into devis (devis, entreprise, secteur, dimension, siret, adresse, cp, ville, nom, prenom, poste, email, fixe, mobile, message) values(:devis, :entreprise, :secteur, :dimension, :siret, :adresse, :cp, :ville, :nom, :prenom, :poste, :email, :fixe, :mobile, :message)";
            // si l'enregistrement existe on le met a jour.
            $sql .= " on duplicate key update devis=:devis, entreprise=:entreprise, secteur=:secteur, dimension=:dimension, siret=:siret, adresse=:adresse, cp=:cp, ville=:ville, nom=:nom, prenom=:prenom, poste=:poste, email=:email, fixe=:fixe, mobile=:mobile, message=:message";

            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if($sth->execute(array(
                ':devis' => $_POST['devis'],
                ':entreprise' => $_POST['entreprise'],
                ':secteur' => $_POST['secteur'],
                ':dimension' => $_POST['dimension'],
                ':siret' => $_POST['siret'],
                ':adresse' => $_POST['adresse'],
                ':cp' => $_POST['cp'],
                ':ville' => $_POST['ville'],
                ':nom' => $_POST['nom'],
                ':prenom' => $_POST['prenom'],
                ':poste' => $_POST['poste'],
                ':email' => $_POST['email'],
                ':fixe' => $_POST['fixe'],
                ':mobile' => $_POST['mobile'],
                ':message' => $_POST['message']
            ))){
                $lastInsertId = $dbh->lastInsertId();

                // si l'element n'existait pas, $lastInsertId => nouvel Id
                // si l'element existait et a été modifié, $lastInsertId => Id de l'element
                // si l'element existait et aucun champ n'a été modifié $lastInsertId => 0

                if ($lastInsertId == 0){
                    $_SESSION['usermessage'] = 'Aucune modification';
                }else{
                    $_SESSION['usermessage'] = 'L\'enregistrement N° '. $lastInsertId .' a été enregistré';
                }

                // la on utilise une redirection au lieu d'un render pour empecher un refresh user
                //header('Location: devis.php');
                header('Location: devis.php?action=commande&devis='.$postada['devis']);
            }else{
                $errors['SQL'] = 'dla merde';
                // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
                $_SESSION['errors'] = $errors;
                $_SESSION['postdata'] = $_POST;

                render('contact/form.php');
            }


        // redirection si des erreurs sont remontées
        } else {
            // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
            $_SESSION['errors'] = $errors;
            $_SESSION['postdata'] = $_POST;

            render('contact/form.php');
        }
    }

// pas d'action donc affichage de liste
}else{
    //requete qui doit retourner tous les resultats de la base
    $results = $dbh->query("select * from devis");
    // recupere les messages dans le connecteur
    $messages = $results->fetchAll();
    // mise en session des messages et redirection
    $_SESSION['messages'] = $messages;

    //render('devis/list.php');
    render('contact/form.php');
}



/*
 * function de TEST des valeurs du formulaire
 */
function checkFields($postdata, $filedata)
{
    $warnings = [];
    $errors = [];
// test Entreprise
    if (isset($postdata['entreprise'])) {
        // si vide
        if (empty($postdata['entreprise'])) {
            $errors['entreprise'] = 'champ entreprise vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['entreprise']) > 50) {
            $errors['entreprise'] = 'champ entreprise trop long (50max)';
        }
    }

// test name
    if (isset($postdata['nom'])) {
        // si vide
        if (empty($postdata['nom'])) {
            $errors['nom'] = 'champ nom vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['nom']) > 50) {
            $errors['nom'] = 'champ nom trop long (50max)';
        }
    }
// test prénom
    if (isset($postdata['prenom'])) {
        // si vide
        if (empty($postdata['prenom'])) {
            $errors['prenom'] = 'champ nom vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['prenom']) > 50) {
            $errors['prenom'] = 'champ prenom trop long (50max)';
        }
    }
// filter_var sur email
    if (isset($postdata['email'])) {
        // si vide
        if (empty($postdata['email'])) {
            $errors['email'] = 'champ email vide';
            // si longueur > 150 chars
        } else if (mb_strlen($postdata['email']) > 150) {
            $errors['email'] = 'champ email trop long (150max)';
            // si format mail invalide
        } else if (!filter_var($postdata['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'champ email non-valide';
        }
    }
// test Telephone
    if (isset($postdata['telephone'])) {
        // si vide
        if (empty($postdata['telephone'])) {
            $errors['telephone'] = 'champ téléphone vide';
            // si longueur > 10 chars
        } else if (!is_numeric($postdata['fixe'])) {
            $errors['telephone'] = 'champ telephone doit comporter uniquement des chiffres';
        } else if (mb_strlen($postdata['fixe']) > 10) {
            $errors['telephone'] = 'Numéro invalide (10max)';
        }
    }
// test si message vide
    if (isset($postdata['question']) && empty(trim($postdata['question']))) {
        $errors['question'] = 'champ message vide';
    }

    return $errors;
}

/*
 * $.post('contact_controller.php', $('#contact_form').serialize())
 *
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

}
*/







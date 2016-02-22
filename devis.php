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
        //Confirmation participation cours
    }else if ($_GET['action'] == 'validation'){
        if (isset($_GET['devis'])&&isset($_GET['id'])){
            // recherche dans la table Réponse les elements avec devis = "$_GET['devis']"
            //$sql = "select * from devis, cours, reponse where devis.devis =:devis and cours.id =:id and reponse.id_cours =:toto ";
            $sql = "select mail_collaborateur, reponse, id_cours, id from reponse INNER JOIN cours ON cours.id=:id INNER JOIN devis ON devis.devis =:devis WHERE id_cours=:id_cours ";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':devis' => $_GET['devis'],
                ':id' => $_GET['id'],
                ':id_cours' => $_GET['id']
            ));
            $confirmation = $sth -> fetchAll();
            echo('<pre>Donnée recupérées ');
            print_r($confirmation);
            echo("</pre>");
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $confirmation;
        }
        render('devis/commande.php');
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
            $commande = $sth -> fetch();
            echo('<pre>Donnée recupérées ');
            print_r($commande);
            echo("</pre>");
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $commande;
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
                $id_cours = $_SESSION['ID-cours'];
                header('Location: devis.php?action=commande&devis='.$lastInsertId.'&id='.$id_cours);
            }else{
                $errors['SQL'] = 'dla merde';
                // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
                $_SESSION['errors'] = $errors;
                $_SESSION['postdata'] = $_POST;

                render('devis/form.php');
            }


        // redirection si des erreurs sont remontées
        } else {
            // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
            $_SESSION['errors'] = $errors;
            $_SESSION['postdata'] = $_POST;

            render('devis/form.php');
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
    render('devis/form.php');
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
// test Secteur activité
    if (isset($postdata['secteur'])) {
        // si vide
        if (empty($postdata['secteur'])) {
            $errors['secteur'] = 'champ secteur vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['secteur']) > 50) {
            $errors['secteur'] = 'champ secteur trop long (50max)';
        }
    }
// test Dimension
    if (isset($postdata['dimension'])) {
        // si vide
        if (empty($postdata['dimension'])) {
            $errors['dimension'] = 'champ dimension vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['dimension']) > 50) {
            $errors['entreprise'] = 'champ dimension trop long (50max)';
        }
    }
// test Siret
    if (isset($postdata['siret'])) {
        // si vide
        if (empty($postdata['siret'])) {
            $errors['siret'] = 'champ nom vide';
            // si longueur > 14 chars
        } else if (!is_numeric($postdata['siret'])) {
            $errors['siret'] = 'champ siret doit comporter uniquement des chiffres';
        } else if (mb_strlen($postdata['siret']) > 14) {
            $errors['siret'] = 'champ siret trop long (14max)';
        }
    }
// test Adresse
    if (isset($postdata['adresse'])) {
        // si vide
        if (empty($postdata['adresse'])) {
            $errors['adresse'] = 'champ adresse vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['adresse']) > 50) {
            $errors['adresse'] = 'champ adresse trop long (50max)';
        }
    }
// test Code Postale
    if (isset($postdata['cp'])) {
        // si vide
        if (empty($postdata['cp'])) {
            $errors['cp'] = 'champ code postal vide';
            // si longueur > 50 chars
        } else if (!is_numeric($postdata['cp'])) {
            $errors['cp'] = 'champ code postal doit comporter uniquement des chiffres';
        } else if (mb_strlen($postdata['cp']) > 5) {
            $errors['cp'] = 'champ code postal trop long (5max)';
        }
    }
// test entreprise
    if (isset($postdata['ville'])) {
        // si vide
        if (empty($postdata['ville'])) {
            $errors['ville'] = 'champ ville vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['ville']) > 50) {
            $errors['ville'] = 'champ ville trop long (50max)';
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
    if (isset($postdata['fixe'])) {
        // si vide
        if (empty($postdata['fixe'])) {
            $errors['fixe'] = 'champ téléphone vide';
            // si longueur > 10 chars
        } else if (!is_numeric($postdata['fixe'])) {
            $errors['fixe'] = 'champ numéro doit comporter uniquement des chiffres';
        } else if (mb_strlen($postdata['fixe']) > 10) {
            $errors['fixe'] = 'Numéro invalide (10max)';
        }
    }
// test Mobile
    if (isset($postdata['mobile'])) {
        // si vide
        if (empty($postdata['mobile'])) {
            $errors['mobile'] = 'champ mobile vide';
            // si longueur > 10 chars
        } else if (!is_numeric($postdata['mobile'])) {
            $errors['mobile'] = 'champ mobile doit comporter uniquement des chiffres';
        } else if (mb_strlen($postdata['fixe']) > 10) {
            $errors['mobile'] = 'Numéro invalide (10max)';
        }
    }

// test si message vide
    if (isset($postdata['message']) && empty(trim($postdata['message']))) {
        $errors['message'] = 'champ message vide';
    }
// test envoi CSV
    if (isset($filedata["file"]) && isset($filedata["file"]['name']) && !empty($filedata["file"]['name'])) {
        $tmp_file = $filedata["file"]['tmp_name'];
        $hires_file = IMG_HIRES_PATH . basename($filedata["file"]["name"]);

        $extension = substr($hires_file,-4);

        if($extension == '.csv'){
            move_uploaded_file($tmp_file, $hires_file);
        }else {
            $errors['file'] = 'Votre fichier doit être au format .CSV';
        }
    }
    return $errors;
}







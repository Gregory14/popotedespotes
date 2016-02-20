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
            $sql = "insert into devis (devis, menu, type_cuisine, association, contraintes) values(:devis, :menu, :type_cuisine, :association, :contraintes)";
            // si l'enregistrement existe on le met a jour.
            $sql .= " on duplicate key update devi=:devis, menu:menu, type_cuisine=:type_cuisine, association=:association, contraintes=:contraintes";

            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if($sth->execute(array(
                ':devis' => $_POST['devis'],
                ':menu' => $_POST['menu'],
                ':type_cuisine' => $_POST['type_cuisine'],
                ':association' => $_POST['association'],
                ':contraintes' => $_POST['contraintes']
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

                render('cours/cours.php');
            }


        // redirection si des erreurs sont remontées
        } else {
            // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
            $_SESSION['errors'] = $errors;
            $_SESSION['postdata'] = $_POST;

            render('cours/cours.php');
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
    render('cours/cours.php');
}



/*
 * function de TEST des valeurs du formulaire
 */
function checkFields($postdata, $filedata)
{
    $warnings = [];
    $errors = [];
// test Entreprise
    if (isset($postdata['menu'])) {
        // si vide
        if (empty($postdata['menu'])) {
            $errors['menu'] = 'champ menu vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['menu']) > 50) {
            $errors['menu'] = 'champ menu trop long (50max)';
        }
    }
// test Secteur activité
    if (isset($postdata['type_cuisine'])) {
        // si vide
        if (empty($postdata['type_cuisine'])) {
            $errors['type_cuisine'] = 'champ type cuisine vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['type_cuisine']) > 50) {
            $errors['type_cuisine'] = 'champ type cuisine trop long (50max)';
        }
    }
// test Dimension
    if (isset($postdata['association'])) {
        // si vide
        if (empty($postdata['association'])) {
            $errors['association'] = 'champ association vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['association']) > 50) {
            $errors['association'] = 'champ association trop long (50max)';
        }
    }
// test Siret
    if (isset($postdata['association'])) {
        // si vide
        if (empty($postdata['association'])) {
            $errors['association'] = 'champ association vide';
            // si longueur > 14 chars
        } else if (mb_strlen($postdata['siret']) > 14) {
            $errors['association'] = 'champ association trop long (50max)';
        }
    }

    return $errors;
}







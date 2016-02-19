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
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $states = array('errors' => checkFields($_POST, $_FILES));
            header('Content-type: application/json');
            echo(json_encode($states, JSON_FORCE_OBJECT));
        }
    // demande d'edition
    }else if ($_GET['action'] == "edit"){
        // est ce qu'on m'a fourni un id ?
        if (isset($_GET['id'])){
            // recherche dans la table message les elements avec id = "$_GET['id']"
            $sql = "select * from cours where id =:id limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':id' => $_GET['id']
            ));
            $reservation = $sth -> fetch();
            //print_r($reservation);
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $reservation;
        }
        render('cours/form.php');

    // demande de sauvegarde de données saisies dans le form
    }else if ($_GET['action'] == "save"){
        // verification des champs, ne traite que les champs fournis
        $errors = checkFields($_POST);

        // redirection si aucune erreur remontée
        if (count($errors) == 0) {

            /* syntaxe avec preparedStatements */
            $sql = "insert into cours (id, offre, lieu, date) values(:id, :offre, :lieu, :date)";
            // si l'enregistrement existe on le met a jour.
            $sql .= " on duplicate key update offre=:offre, lieu=:lieu, date=:date";

            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if($sth->execute(array(
                ':id' => $_POST['id'],
                ':offre' => $_POST['offre'],
                ':lieu' => $_POST['lieu'],
                ':date' => $_POST['date']
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
                header('Location: reservation.php');
            }else{
                $errors['SQL'] = 'dla merde';
                // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
                $_SESSION['errors'] = $errors;
                $_SESSION['postdata'] = $_POST;

                render('cours/form.php');
            }


        // redirection si des erreurs sont remontées
        } else {
            // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
            $_SESSION['errors'] = $errors;
            $_SESSION['postdata'] = $_POST;

            render('cours/form.php');
        }
    }

// pas d'action donc affichage de liste
}else{
    //requete qui doit retourner tous les resultats de la base
    $results = $dbh->query("select * from cours");
    // recupere les messages dans le connecteur
    $messages = $results->fetchAll();
    // mise en session des messages et redirection
    $_SESSION['messages'] = $messages;

    render('cours/list.php');
}



/*
 * function de TEST des valeurs du formulaire
 */
function checkFields($postdata, $filedata)
{
    $warnings = [];
    $errors = [];
// test Offre
    if (isset($postdata['offre'])) {
        // si vide
        if (empty($postdata['offre'])) {
            $errors['offre'] = 'champ offre vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['offre']) > 50) {
            $errors['offre'] = 'champ offre trop long (50max)';
        }
    }
// test Lieu
    if (isset($postdata['lieu'])) {
        // si vide
        if (empty($postdata['lieu'])) {
            $errors['lieu'] = 'champ menu vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['menu']) > 50) {
            $errors['lieu'] = 'champ lieu trop long (50max)';
        }
    }
// test Type Cuisine
    if (isset($postdata['type_cuisine'])) {
        // si vide
        if (empty($postdata['type_cuisine'])) {
            $errors['type_cuisine'] = 'champ type cuisine vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['dimension']) > 50) {
            $errors['type_cuisine'] = 'champ type cuisine trop long (50max)';
        }
    }

    return $errors;
}
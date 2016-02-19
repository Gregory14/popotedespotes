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
        if (isset($_GET['cours'])){
            // recherche dans la table message les elements avec id = "$_GET['id']"
            $sql = "select * from cours where cours =:cours limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':cours' => $_GET['cours']
            ));
            $message = $sth -> fetch();
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $message;
        }
        render('cours/form.php');

    // demande de sauvegarde de données saisies dans le form
    }else if ($_GET['action'] == "save"){
        // verification des champs, ne traite que les champs fournis
        $errors = checkFields($_POST);

        // redirection si aucune erreur remontée
        if (count($errors) == 0) {

            /* syntaxe avec preparedStatements */
            $sql = "insert into cours (id, offre, menu, type_cuisine, lieu, date, association) values(:id, :offre, :menu, :type_cuisine, :lieu, :date, :association)";
            // si l'enregistrement existe on le met a jour.
            $sql .= " on duplicate key update id=:id, offre=:offre, menu=:menu, type_cuisine=:type_cuisine, lieu=:lieu, date=:date, association:association";

            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if($sth->execute(array(
                ':id' => $_POST['id'],
                ':offre' => $_POST['offre'],
                ':menu' => $_POST['menu'],
                ':type_cuisine' => $_POST['type_cuisine'],
                ':lieu' => $_POST['lieu'],
                ':date' => $_POST['date'],
                ':association' => $_POST['association']
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
// test Menu
    if (isset($postdata['menu'])) {
        // si vide
        if (empty($postdata['menu'])) {
            $errors['menu'] = 'champ menu vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['menu']) > 50) {
            $errors['menu'] = 'champ menu trop long (50max)';
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
// test si message vide
    if (isset($postdata['message']) && empty(trim($postdata['message']))) {
        $errors['message'] = 'champ message vide';
    }

    return $errors;
}

/*
 * $.post('contact_controller.php', $('#contact_form').serialize())
 *
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

}
*/







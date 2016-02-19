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
            $sql = "select * from message where id =:id limit 1";
            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $sth->execute(array(
                ':id' => $_GET['id']
            ));
            $message = $sth -> fetch();
            // mise en session du contenu de l'element demandé
            $_SESSION['postdata'] = $message;
        }
        render('message/form.php');

    // demande de sauvegarde de données saisies dans le form
    }else if ($_GET['action'] == "save"){
        // verification des champs, ne traite que les champs fournis
        $errors = checkFields($_POST, $_FILES);

        // redirection si aucune erreur remontée
        if (count($errors) == 0) {

            // test de merde, dans le cas d'un rechargement on devrait ne pas updater les images ?
            $hires_filename = !empty($_POST['hires'])?$_POST['hires']:'';
            $thumb_filename = !empty($_POST['thumb'])?$_POST['thumb']:'';
            $filedata = $_FILES;
            if (isset($filedata["image"]) && isset($filedata["image"]['name']) && !empty($filedata["image"]['name'])) {

                $hires_filename = basename($filedata["image"]["name"]);
                // pathinfo permet de retrouver l'extension en fonction d'un chemin de fichier complet
                $hires_info = pathinfo($hires_filename);
                // on recupere le nom de fichier sans l'extension
                // et nomme le thumbnail en tant que jpeg
                $thumb_filename = $hires_info['filename'] . '.jpeg';
            }


            /* syntaxe avec preparedStatements */
            $sql = "insert into message (id, name, email, message, hires, thumb) values(:id, :name, :email, :message, :hires_file, :thumb_file)";
            // si l'enregistrement existe on le met a jour.
            $sql .= " on duplicate key update name=:name, email=:email, message=:message, hires=:hires_file, thumb=:thumb_file";

            $sth = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            if($sth->execute(array(
                ':id' => $_POST['id'],
                ':name' => $_POST['name'],
                ':email' => $_POST['email'],
                ':message' => $_POST['message'],
                ':hires_file' => $hires_filename,
                ':thumb_file' => $thumb_filename
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
                header('Location: message.php');
            }else{
                $errors['SQL'] = 'dla merde';
                // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
                $_SESSION['errors'] = $errors;
                $_SESSION['postdata'] = $_POST;

                render('message/form.php');
            }


        // redirection si des erreurs sont remontées
        } else {
            // si ca marcha pas on mets les errors et les champs fournis par $_POST en session
            $_SESSION['errors'] = $errors;
            $_SESSION['postdata'] = $_POST;

            render('message/form.php');
        }
    }

// pas d'action donc affichage de liste
}else{
    //requete qui doit retourner tous les resultats de la base
    $results = $dbh->query("select * from message");
    // recupere les messages dans le connecteur
    $messages = $results->fetchAll();
    // mise en session des messages et redirection
    $_SESSION['messages'] = $messages;

    render('message/list.php');
}



/*
 * function de TEST des valeurs du formulaire
 */
function checkFields($postdata, $filedata)
{
// test name
    $warnings = [];
    $errors = [];
    if (isset($postdata['name'])) {
        // si vide
        if (empty($postdata['name'])) {
            $errors['name'] = 'champ name vide';
            // si longueur > 50 chars
        } else if (mb_strlen($postdata['name']) > 50) {
            $errors['name'] = 'champ name trop long (50max)';
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
// test image et resize
    if (isset($filedata["image"]) && isset($filedata["image"]['name']) && !empty($filedata["image"]['name'])) {
        $tmp_file = $filedata["image"]['tmp_name'];
        $hires_file = IMG_HIRES_PATH . basename($filedata["image"]["name"]);

        // pathinfo permet de retrouver l'extension en fonction d'un chemin de fichier complet
        $hires_info = pathinfo($hires_file);
        // on recupere le nom de fichier sans l'extension
        // et nomme le thumbnail en tant que jpeg
        $thumb_file_name = $hires_info['filename'] . '.jpeg';
        // on defini le path complet que devra avoir le fichier redimensionné
        $thumb_file = IMG_THUMBS_PATH . $thumb_file_name;

        // on peut le deplacer ?
        if (move_uploaded_file($tmp_file, $hires_file)) {
            // recupere les dimensions de l'image originale et les met dans $width et $height
            list($width, $height) = getimagesize($hires_file);
            $ratio = (IMG_THUMBS_WIDTH / $width);
            // calcul des dimensions de l'image redimensionnée
            $new_width = round($width * $ratio);
            $new_height = round($height * $ratio);
            // lecture en memoire de l'image originale
            $hires_img = imagecreatefromstring(file_get_contents($hires_file));
            //creation en memoire d'une image noire des nouvelles dimensions
            $thumb_img = imagecreatetruecolor($new_width, $new_height);

            // on peut redimensionner ?
            if (imagecopyresampled($thumb_img, $hires_img, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
                // une erreur lors de l'ecriture du thumbnail ?
                if (!imagejpeg($thumb_img, $thumb_file)) {
                    $errors['image'] = 'erreur ecriture thumbnail image';
                }
            } else {
                $errors['image'] = 'erreur generation thumbnail image';
            }
        } else {
            $errors['image'] = 'erreur deplacement fichier image';
        }

    }
    return $errors;
}

/*
 * $.post('contact_controller.php', $('#contact_form').serialize())
 *
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

}
*/







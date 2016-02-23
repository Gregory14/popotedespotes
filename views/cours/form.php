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
    <section class="overlayContainer col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 ">
<h1>Réserver une session</h1>


<form method="post" action="reservation.php?action=save" enctype="multipart/form-data" id="cours_form"
      class="form-horizontal col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1">
    <?php
    if (isset($postdata) && isset($postdata['id']) && !empty($postdata['id']) ){
        print_r($postdata);
    ?>
    <input type="text" name="id" value="<?php echo $postdata['id'] ?>">
    <?php
    }
    ?>
    <div class="form-group has-feedback">
        <label for="offre" class="row control-label"><h3>Nombre de participant</h3></label>

        <div class="row">
            <label class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                <img src="img/select10/select10.jpg" alt="">
                <input type="radio" id="offre1" name="offre" value="10"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='10') {echo 'checked';} ?>
                >

                <span>Jusqu'à 10 personnes</span>
            </label>

            <label class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-8 col-xs-offset-2">
                <img src="img/select10/select20.jpg" alt="">
                <input type="radio" id="offre2" name="offre" value="20"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='20') {echo 'checked';} ?>
                > <span>Entre de 10 et 19 personnes</span>
            </label>

            <label class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                <img src="img/select10/select30.jpg" alt="">
                <input type="radio" id="offre3" name="offre" value="offre3"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='30') {echo 'checked';} ?>
                > <span>Entre de 20 et 29 personnes</span>
            </label>

            <label class="col-lg-3 col-lg-offset-0 col-md-3 col-md-offset-0 col-sm-4 col-sm-offset-0 col-xs-8 col-xs-offset-2">
                <img src="img/select10/select40.jpg" alt="">
                <input type="radio" id="offre4" name="offre" value="offre4"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='31') {echo 'checked';} ?>
                > <span>Plus de 30 personnes</span>
            </label>
        </div>
    </div>


    <div class="form-group has-feedback">
        <label for="lieu" class="row control-label"><h3>Où cuisiner ?</h3></label>

        <div class="row">
            <label class="col-xs-6">
                <input type="radio" id="lieu1" name="lieu" value="lieu1"
                    <?php if (isset($postdata['lieu']) && $postdata['lieu']=='lieu1') {echo 'checked';} ?>
                > Nous avons des locaux
            </label>

            <label class="col-xs-6">
                <input type="radio" id="lieu2" name="lieu" value="lieu2"
                    <?php if (isset($postdata['lieu']) && $postdata['lieu']=='lieu2') {echo 'checked';} ?>
                > Nous avons besoins d'un lieu
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="date" class="row control-label"><h3>Date</h3></label>

        <div class="row">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
                        <div id="datetimepicker1"><input type='text' name="date" class="collapse" value="<?php if (isset($postdata['date']) && !empty($postdata['date'])) {echo $postdata['date'];} ?>"/></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="submit" id="ajax_form_check" class="btn btn-primary" value="Recevoir un devis">

</form>
        </section>
    </div>
<script>

    $(function () {

        $('#datetimepicker1').datetimepicker({
            inline: true,
            sideBySide: false,
            format: 'YYYY-MM-DD',
            minDate: 'moment'
        });
    });

</script>

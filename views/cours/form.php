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

<h1>Réserver une session</h1>


<form method="post" action="reservation.php?action=save" enctype="multipart/form-data" id="cours_form"
      class="form-horizontal">
    <?php
    if (isset($postdata) && isset($postdata['id']) && !empty($postdata['id']) ){
        print_r($postdata);
    ?>
    <input type="text" name="id" value="<?php echo $postdata['id'] ?>">
    <?php
    }
    ?>
    <div class="form-group has-feedback">
        <label for="offre" class="col-xs-2 control-label">Nombre de participant</label>

        <div class="col-xs-6">
            <label class="col-xs-3">
                <input type="radio" id="offre1" name="offre" value="10"
                <?php if (isset($postdata['offre']) && $postdata['offre']=='10') {echo 'checked';} ?>
                > Jusqu'à 10 personnes
            </label>

            <label class="col-xs-3">
                <input type="radio" id="offre2" name="offre" value="20"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='20') {echo 'checked';} ?>
                > Entre 10 et 19 personnes
            </label>

            <label class="col-xs-3">
                <input type="radio" id="offre3" name="offre" value="offre3"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='30') {echo 'checked';} ?>
                > Entre 20 et 29 personnes
            </label>

            <label class="col-xs-3">
                <input type="radio" id="offre4" name="offre" value="offre4"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='31') {echo 'checked';} ?>
                > Plus de 30 personnes
            </label>
        </div>
    </div>


    <div class="form-group has-feedback">
        <label for="lieu" class="col-xs-2 control-label">Où cuisiner ?</label>

        <div class="col-xs-6">
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
        <label for="date" class="col-xs-2 control-label">Date</label>

        <div style="overflow: hidden;">
            <div class="form-group">
                <div class="row">
                    <div class="col-md-6">
                        <div id="datetimepicker1"><input type='text' name="date" class="collapse" value="<?php if (isset($postdata['date']) && !empty($postdata['date'])) {echo $postdata['date'];} ?>"/></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="submit" id="ajax_form_check" class="btn btn-primary" value="Recevoir un devis">

</form>
<script>

    $(function () {

        $('#datetimepicker1').datetimepicker({
            inline: true,
            sideBySide: false,
            format: 'YYYY-MM-DD',
            minDate: 'moment'
        });
    }

</script>

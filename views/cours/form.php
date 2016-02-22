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

<div class="container overlayContainer">
    <div class="row">
<h1>Réserver une session</h1>
        <p class="col-lg-8 col-lg-offset-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
    </div>

<form method="post" action="reservation.php?action=save" enctype="multipart/form-data" id="cours_form"
      class="form-horizontal col-lg-8 col-lg-offset-2">
    <?php
    if (isset($postdata) && isset($postdata['id']) && !empty($postdata['id']) ){
        print_r($postdata);
    ?>
    <input type="text" name="id" value="<?php echo $postdata['id'] ?>">
    <?php
    }
    ?>
    <div class="form-group has-feedback">
        <label for="offre" class="col-lg-12 control-label">Nombre de participant</label>

        <div class="">
            <label class="">
                <input type="radio" id="offre1" name="offre" value="offre1"
                <?php if (isset($postdata['offre']) && $postdata['offre']=='offre1') {echo 'checked';} ?>
                > Jusqu'à 10 personnes
            </label>

            <label class="">
                <input type="radio" id="offre2" name="offre" value="offre2"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='offre2') {echo 'checked';} ?>
                > Entre 10 et 19 personnes
            </label>

            <label class="">
                <input type="radio" id="offre3" name="offre" value="offre3"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='offre3') {echo 'checked';} ?>
                > Entre 20 et 29 personnes
            </label>

            <label class="">
                <input type="radio" id="offre4" name="offre" value="offre4"
                    <?php if (isset($postdata['offre']) && $postdata['offre']=='offre4') {echo 'checked';} ?>
                > Plus de 30 personnes
            </label>
        </div>
    </div>


    <div class="form-group has-feedback">
        <label for="lieu" class="col-lg-12 control-label">Où cuisiner ?</label>

        <div class="">
            <label class="">
                <input type="radio" id="lieu1" name="lieu" value="lieu1"
                    <?php if (isset($postdata['lieu']) && $postdata['lieu']=='lieu1') {echo 'checked';} ?>
                > Nous avons des locaux
            </label>

            <label class="">
                <input type="radio" id="lieu2" name="lieu" value="lieu2"
                    <?php if (isset($postdata['lieu']) && $postdata['lieu']=='lieu2') {echo 'checked';} ?>
                > Nous avons besoins d'un lieu
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="date" class=" control-label">Date</label>

        <div style="overflow: hidden;">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12">
                        <div id="datetimepicker1"><input type='text' name="date" class="collapse" value="<?php if (isset($postdata['date']) && !empty($postdata['date'])) {echo $postdata['date'];} ?>"/></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <input type="submit" id="ajax_form_check" class="btn" value="Recevoir un devis">

</form>
    </div>
<script>
    var phpErrors = <?php echo (count($errors)?json_encode($errors, JSON_FORCE_OBJECT):'{}') ?>;
</script>
<script>

    $(function () {

        $('#datetimepicker1').datetimepicker({
            inline: true,
            sideBySide: false,
            format: 'YYYY-MM-DD',
            minDate: 'moment'
        });

        // errors display function
        function showErrors(errors, inputName, showAsPopover) {
            var targetElt = $('#' + inputName);
            targetElt.closest('.form-group').find('[class*="text-"], .form-control-feedback').remove();
            if (!!errors[inputName]) {
                targetElt.closest('.form-group')
                    .removeClass('has-success')
                    .addClass('has-error');

                if (showAsPopover) {
                    targetElt
                        .after($('<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                    if (targetElt.data('bs.popover')) {
                        targetElt.data('bs.popover').options.content = errors[inputName]

                    } else {
                        targetElt.popover({
                            content: errors[inputName]
                        })
                    }
                    targetElt.popover('show');
                } else {
                    targetElt
                        .after($('<p class="text-danger">' + errors[inputName] + '</p>'))
                        .after($('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                        .popover('destroy');
                }
            } else {
                targetElt.closest('.form-group')
                    .removeClass('has-error')
                    .addClass('has-success')

                targetElt.after($('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span><span id="inputSuccess2Status" class="sr-only">(success)</span>'))
                    .popover('destroy');
            }
        }

        // on focus
        // do nothing, cleanup awaiting user input

        $('#cours_form input, #cours_form textarea').on('focus', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('focus', this);
            var that = this;
            var targetElt = $(that);
            targetElt.closest('.form-group')
                .removeClass('has-error')
                .find('[class*="text-"], .form-control-feedback')
                .remove();
        });

        // on keyup
        // check if input is Ok via ajax, if not, display a warning in popover

        $('#cours_form input, #cours_form textarea').on('keyup', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('keyup', this);
            var that = this;
            $.post(
                'reservation.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 1);
                }
            );
        });

        // on blur
        // check if input is Ok via ajax, if not, display a warning under field
        // remove previous popovers

        $('#cours_form input, #cours_form textarea').on('blur', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('blur', this);
            var that = this;
            $.post(
                'reservation.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 0);
                }
            );
        });

        // display errors if errors retrieved from PHP form submit
        $('#cours_form input, #cours_form textarea').each(function () {
            var that = this;
            var inputName = $(that).attr('name');
            var errors = phpErrors;
            if(errors[inputName]) {
                showErrors(errors, inputName, 0);
            }
        });

    });

</script>

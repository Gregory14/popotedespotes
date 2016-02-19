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
var_dump($postdata);
$test = implode(",", $postdata['menu']);
print_r($test);
?>

<h1>Information sur votre cours</h1>


<form method="post" action="reservation.php?action=save" enctype="multipart/form-data" id="cours_cours"
      class="form-horizontal">

    <div class="form-group has-feedback">
        <label for="menu" class="col-xs-2 control-label">Choix du menu</label>

        <div class="col-xs-6">
            <label class="col-xs-4">
                <input type="checkbox" id="menu1" name="menu[]" value="entrée"> Entrée
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="menu2" name="menu[]" value="plat"> Plats
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="menu3" name="menu[]" value="dessert"> Dessert
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="theme_cuisine" class="col-xs-2 control-label">Choix du menu</label>

        <div class="col-xs-6">
            <label class="col-xs-4">
                <input type="checkbox" id="theme_cuisine1" name="theme_cuisine[]" value="traditionelle"> Cuisine traditionnelle
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="theme_cuisine2" name="theme_cuisine[]" value="monde"> Cuisine du monde
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="theme_cuisine3" name="theme_cuisine[]" value="gastronomie"> Cuisine Gastonomique
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="association" class="col-xs-2 control-label">Pour qui cuisiner ?</label>

        <div class="col-xs-6">
            <label class="col-xs-3">
                <input type="checkbox" id="association1" name="association[]" value="resto-du-coeur"> Resto du coeur
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association2" name="association[]" value="secours-populaire"> Secours populaire
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association3" name="association[]" value="croix-rouge"> Croix rouge
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association4" name="association[]" value="association"> Association
            </label>
        </div>
    </div>

    <input type="submit" id="ajax_form_check" class="btn btn-primary" value="Recevoir un devis">

</form>
<script>
    var phpErrors = <?php echo (count($errors)?json_encode($errors, JSON_FORCE_OBJECT):'{}') ?>;
</script>
<script>

    $(function () {


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

        $('#devis_form input, #devis_form textarea').on('focus', function (e) {
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

        $('#devis_form input, #devis_form textarea').on('keyup', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('keyup', this);
            var that = this;
            $.post(
                'devis.php?action=check',
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

        $('#devis_form input, #devis_form textarea').on('blur', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('blur', this);
            var that = this;
            $.post(
                'devis.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 0);
                }
            );
        });

        // display errors if errors retrieved from PHP form submit
        $('#devis_form input, #devis_form textarea').each(function () {
            var that = this;
            var inputName = $(that).attr('name');
            var errors = phpErrors;
            if(errors[inputName]) {
                showErrors(errors, inputName, 0);
            }
        });

    });

</script>
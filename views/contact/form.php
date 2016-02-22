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
<h1>Une question ?</h1>

<p class="col-lg-8 col-lg-offset-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
    </div>

<h2>Contactez-nous</h2>

<form method="post" action="contact.php?action=save" enctype="multipart/form-data" id="contact_form"
      class="form-horizontal">

    <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="name" class=" control-label">Nom</label>

        <div class="">
            <input type="text" id="nom" name="nom" class="form-control" placeholder="Bob"
                   value="<?php echo !empty($postdata['nom']) ? ($postdata['nom']) : '' ?>">
        </div>
    </div>

    <div class="has-feedback col-lg-4">
        <label for="prenom" class=" control-label">Prénom</label>

        <div class="">
            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="Jean"
                   value="<?php echo !empty($postdata['prenom']) ? ($postdata['prenom']) : '' ?>">
        </div>
    </div>

    <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="email" class=" control-label">Email</label>

        <div class="">
            <input type="text" autocomplete="0" id="email" name="email" class="form-control"
                   placeholder="votre mail"
                   value="<?= !empty($postdata['email']) ? ($postdata['email']) : '' ?>">
        </div>
    </div>

    <div class="has-feedback col-lg-4">
        <label for="telephone" class=" control-label">Téléphone</label>

        <div class="">
            <input type="text" id="telephone" name="telephone" class="form-control" placeholder="0176543975"
                   value="<?php echo !empty($postdata['telephone']) ? ($postdata['telephone']) : '' ?>">
        </div>
    </div>

    <div class="has-feedback col-lg-8 col-lg-offset-2">
        <label for="entreprise" class=" control-label">Entreprise</label>
            <input type="text" id="entreprise" name="entreprise" class="form-control" placeholder="La popote des potes"
                   value="<?php echo !empty($postdata['entreprise']) ? ($postdata['entreprise']) : '' ?>">
    </div>

    <div class="has-feedback col-lg-8 col-lg-offset-2">
        <label for="question" class=" control-label">Votre question</label>

            <textarea id="question"
                      name="question"
                      class="form-control"
                      placeholder="un petit message ?"><?= !empty($postdata['question']) ? ($postdata['question']) : '' ?></textarea>
    </div>
    <div class="col-lg-2 col-lg-offset-8"><input type="submit" id="ajax_form_check" class="btn" value="Envoyer"></div>
</form>

</div>
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

        $('#contact_form input, #contact_form textarea').on('focus', function (e) {
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

        $('#contact_form input, #contact_form textarea').on('keyup', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('keyup', this);
            var that = this;
            $.post(
                'contact.php?action=check',
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

        $('#contact_form input, #contact_form textarea').on('blur', function (e) {
            e.preventDefault() && e.stopPropagation();
            console.log('blur', this);
            var that = this;
            $.post(
                'contact.php?action=check',
                $(that).serialize(),
                function (data) {
                    var inputName = $(that).attr('name');
                    var errors = data['errors'];
                    showErrors(errors, inputName, 0);
                }
            );
        });

        // display errors if errors retrieved from PHP form submit
        $('#contact_form input, #contact_form textarea').each(function () {
            var that = this;
            var inputName = $(that).attr('name');
            var errors = phpErrors;
            if(errors[inputName]) {
                showErrors(errors, inputName, 0);
            }
        });

    });

</script>

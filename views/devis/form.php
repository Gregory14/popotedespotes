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
    <section class="col-lg-10 col-lg-offset-1 overlayContainer">
        <div class="row">

<h1>Demande de devis</h1>

            </div>

<form method="post" action="devis.php?action=save" enctype="multipart/form-data" id="devis_form"
      class="form-horizontal">
    <h3>Votre entreprise</h3>

    <?php
    if (isset($postdata) && isset($postdata['devis']) && !empty($postdata['devis']) ){
        ?>
        <div class="has-feedback col-lg-12">
            <label for="devis" class="control-label">Devis n°</label>

            <div class="">
                <input type="text" id="devis" name="devis" class="form-control" readonly placeholder=""
                       value="<?php echo !empty($postdata['devis']) ? ($postdata['devis']) : '' ?>">
            </div>
        </div>
        <?php
    }
    ?>
<div class="row">
    <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="entreprise" class="control-label">Entreprise</label>

        <div class="">
            <input type="text" id="entreprise" name="entreprise" class="form-control" placeholder="i.e : La popote des potes"
                   value="<?php echo !empty($postdata['entreprise']) ? ($postdata['entreprise']) : '' ?>">
        </div>
    </div>


    <div class="has-feedback col-lg-4">
        <label for="secteur" class="control-label">Secteur d'activité</label>

        <div class="">
            <select id="secteur" name="secteur" class="form-control">
                    <option value="Agricole" <?php if (isset($postdata['secteur']) && $postdata['secteur']=='Agricole') {echo 'selected';} ?>>Agricole</option>
                    <option value="Automobile" <?php if (isset($postdata['secteur']) && $postdata['secteur']=='Automobile') {echo 'selected';} ?>>Automobile</option>
                    <option value="Finance" <?php if (isset($postdata['secteur']) && $postdata['secteur']=='Finance') {echo 'selected';} ?>>Finance</option>
                    <option value="Banque" <?php if (isset($postdata['secteur']) && $postdata['secteur']=='Banque') {echo 'selected';} ?>>Banque</option>
                    <option value="Education" <?php if (isset($postdata['secteur']) && $postdata['secteur']=='Education') {echo 'selected';} ?>>Education</option>
            </select>
        </div>
    </div>
    </div>

<div class="row">
    <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="dimension" class="control-label">Dimension de l'entreprise</label>

        <div class="">
            <select id="dimension" name="dimension" class="form-control">
                    <option value="small" <?php if (isset($postdata['dimension']) && $postdata['dimension']=='small') {echo 'selected';} ?>>Moins de 10</option>
                    <option value="little" <?php if (isset($postdata['dimension']) && $postdata['dimension']=='little') {echo 'selected';} ?>>Entre 10 et 20</option>
                    <option value="normal" <?php if (isset($postdata['dimension']) && $postdata['dimension']=='normal') {echo 'selected';} ?>>Entre 21 et 30</option>
                    <option value="big" <?php if (isset($postdata['dimension']) && $postdata['dimension']=='big') {echo 'selected';} ?>>A partir de 31</option>
            </select>
            </div>
        </div>


    <div class="has-feedback col-lg-4">
        <label for="siret" class="control-label">Siret</label>

        <div class="">
            <input type="text" id="siret" name="siret" class="form-control" placeholder="12345678903456"
                   value="<?php echo !empty($postdata['siret']) ? ($postdata['siret']) : '' ?>">
        </div>
    </div>
</div>
    <div class="row">
    <div class="has-feedback col-lg-8 col-lg-offset-2">
        <label for="adresse" class="control-label">Adresse</label>

        <div class="">
            <input type="text" id="adresse" name="adresse" class="form-control" placeholder="7 rue froment"
                   value="<?php echo !empty($postdata['adresse']) ? ($postdata['adresse']) : '' ?>">
        </div>
    </div>
        </div>
        <div class="row">

            <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="code postal" class="control-label">Code postale</label>

        <div class="">
            <input type="tel" id="cp" name="cp" class="form-control" placeholder="75001"
                   value="<?php echo !empty($postdata['cp']) ? ($postdata['cp']) : '' ?>">
        </div>
    </div>

            <div class="has-feedback col-lg-4">
        <label for="ville" class="control-label">Ville</label>

        <div class="">
            <input type="text" id="ville" name="ville" class="form-control" placeholder="Paris"
                   value="<?php echo !empty($postdata['ville']) ? ($postdata['ville']) : '' ?>">
        </div>
    </div>
            </div>

    <h3>Vos informations de contact</h3>
    <div class="row">
        <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="name" class="control-label">Nom</label>

        <div class="">
            <input type="text" id="nom" name="nom" class="form-control" placeholder="i.e : Dupont"
                   value="<?php echo !empty($postdata['nom']) ? ($postdata['nom']) : '' ?>">
        </div>
    </div>

    <div class="has-feedback col-lg-4">
        <label for="prenom" class="control-label">Prénom</label>

        <div class="">
            <input type="text" id="prenom" name="prenom" class="form-control" placeholder="i.e : Paul"
                   value="<?php echo !empty($postdata['prenom']) ? ($postdata['prenom']) : '' ?>">
        </div>
    </div>
        </div>

    <div class="row">

        <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="poste" class="col-xs-2 control-label">Poste</label>

        <div class="">
            <input type="text" id="poste" name="poste" class="form-control" placeholder="DRH"
                   value="<?php echo !empty($postdata['poste']) ? ($postdata['poste']) : '' ?>">
        </div>
    </div>

        <div class="has-feedback col-lg-4">
        <label for="email" class="col-xs-2 control-label">Email</label>

        <div class="">
            <input type="text" autocomplete="0" id="email" name="email" class="form-control"
                   placeholder="i.e : exemple@lapopotedespotes.net"
                   value="<?= !empty($postdata['email']) ? ($postdata['email']) : '' ?>">
        </div>
    </div>
        </div>

    <div class="row">

        <div class="has-feedback col-lg-4 col-lg-offset-2">
        <label for="fixe" class="control-label">Téléphone</label>

        <div class="">
            <input type="tel" id="fixe" name="fixe" class="form-control" placeholder="i.e : 01234567890"
                   value="<?php echo !empty($postdata['fixe']) ? ($postdata['fixe']) : '' ?>">
        </div>
    </div>

        <div class="has-feedback col-lg-4">
        <label for="portable" class="control-label">Portable</label>

        <div class="">
            <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="i.e : 04568758"
                   value="<?php echo !empty($postdata['mobile']) ? ($postdata['mobile']) : '' ?>">
        </div>
    </div>
        </div>

    <div class="row">
        <div class="has-feedback col-lg-8 col-lg-offset-2">
        <label for="message" class="control-label">Informations complémentaires</label>

        <div class="">
            <textarea id="message"
                      name="message"
                      class="form-control"
                      placeholder="un petit message ?"><?= !empty($postdata['message']) ? ($postdata['message']) : '' ?></textarea>
        </div>
    </div>
        </div>

    <div class="row">
        <div class="has-feedback col-lg-8 col-lg-offset-2">
        <label for="file" class="control-label">Importez les mail de vos collaborateurs invités</label>

        <div class="">
            <input type="file" id="file" name="file" class="form-control"
                   placeholder="Fichier .CSV">
                <input type="hidden" name="file_send" id="file_send" value="<?php echo $postdata['file'] ?>">
        </div>
    </div>

        <div class="has-feedback col-lg-8 col-lg-offset-2 btn-container">
    <input type="submit" id="ajax_form_check" class="btn" value="Valider le devis">
            </div>
        </div>
</form>
    </section></div>
<script>
    var phpErrors = <?php echo (count($errors)?json_encode($errors, JSON_FORCE_OBJECT):'{}') ?>;
</script>
<script>

    $(function () {

        $('#datetimepicker1').datetimepicker();

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

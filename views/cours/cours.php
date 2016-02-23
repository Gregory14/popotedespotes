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

<h1>Votre cours de cuisine du monde</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>

<section>
    <h2>La recette</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
</section>

<section>
    <h2>Les ingrédients</h2>
    <div><img src="" alt="">
        <h3>Cuisiner des invendus</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
    </div>
    <div><img src="" alt="">
        <h3>Avec un chef</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
    </div>
    <div><img src="" alt="">
        <h3>Pour aider</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porttitor erat eu lorem consequat lobortis. Integer tortor elit, sodales sed rutrum finibus, pellentesque tincidunt ex. In in enim tellus. Aliquam erat volutpat. Sed volutpat viverra urna, nec aliquam orci venenatis sed. Nam gravida blandit nulla, a accumsan quam luctus lacinia. Donec blandit libero sit amet augue ultricies rhoncus.</p>
    </div>
</section>

<section>
    <h2>Le chef</h2>
    <h3>Thierry Marx</h3>
    <img src="" alt="">
</section>

<form method="post" action="mon-cours.php?action=save" enctype="multipart/form-data" id="cours"
      class="form-horizontal">
    <?php
    if (isset($postdata) && isset($postdata['id']) && !empty($postdata['id']) ){
        print_r($postdata);
        ?>
        <input type="text" name="id" value="<?php echo $postdata['id'] ?>">
        <?php
    }else {?>
        <input type="text" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
    ?>

    <div class="form-group has-feedback">
        <label for="menu" class="col-xs-2 control-label">Choix du menu</label>

        <div class="col-xs-6">
            <label class="col-xs-4">
                <input type="checkbox" id="menu1" name="menu[]" value="entrée"
                <?php if (isset($postdata['menu']) && $postdata['menu'][0]=='entrée') {echo 'checked';} ?>> Entrée
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="menu2" name="menu[]" value="plat"
                <?php if (isset($postdata['menu']) && ($postdata['menu'][0]=='plat' || $postdata['menu'][1]=='plat')) {echo 'checked';} ?>> Plats
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="menu3" name="menu[]" value="dessert"
                <?php if (isset($postdata['menu']) && (($postdata['menu'][0]) =='dessert' || $postdata['menu'][1] =='dessert' || $postdata['menu'][2] =='dessert')) {echo 'checked';} ?>> Dessert
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="type_cuisine" class="col-xs-2 control-label">Type de cuisine</label>

        <div class="col-xs-6">
            <label class="col-xs-4">
                <input type="checkbox" id="type_cuisine1" name="type_cuisine[]" value="traditionelle"
                <?php if (isset($postdata['type_cuisine']) && $postdata['type_cuisine'][0]=='traditionelle') {echo 'checked';} ?>> Cuisine traditionnelle
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="type_cuisine2" name="type_cuisine[]" value="monde"
                <?php if (isset($postdata['type_cuisine']) && ($postdata['type_cuisine'][0]=='monde'||$postdata['type_cuisine'][1]=='monde')) {echo 'checked';} ?>> Cuisine du monde
            </label>

            <label class="col-xs-4">
                <input type="checkbox" id="type_cuisine3" name="type_cuisine[]" value="gastronomie"
                <?php if (isset($postdata['type_cuisine']) && ($postdata['type_cuisine'][0]=='gastronomie'||$postdata['type_cuisine'][1]=='gastronomie')||$postdata['type_cuisine'][2]=='gastronomie') {echo 'checked';} ?>> Cuisine Gastonomique
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="association" class="col-xs-2 control-label">Pour qui cuisiner ?</label>

        <div class="col-xs-6">
            <label class="col-xs-3">
                <input type="checkbox" id="association1" name="association[]" value="les petits frère des pauvres"
                <?php if (isset($postdata['association']) && $postdata['association'][0]=='les petits frère des pauvres') {echo 'checked';} ?>> Les petits frère des pauvres
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association2" name="association[]" value="la banque alimentaire"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='la banque alimentaire'||$postdata['association'][1]=='la banque alimentaire')) {echo 'checked';} ?>> La banque alimentaire
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association3" name="association[]" value="armee du salut"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='armee du salut' || $postdata['association'][1]=='armee du salut' || $postdata['association'][2]=='armee du salut')) {echo 'checked';} ?>> L'armee du salut
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="association4" name="association[]" value="les restaurants du coeur"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='les restaurants du coeur' || $postdata['association'][1]=='les restaurants du coeur' || $postdata['association'][2]=='les restaurants du coeur')) {echo 'checked';} ?>> Les restaurants du coeur
            </label>
        </div>
    </div>

    <div class="form-group has-feedback">
        <label for="contraintes" class="col-xs-2 control-label">Mon cours</label>
        <div></div>

        <div class="col-xs-6">
            <label class="col-xs-3">
                <input type="checkbox" id="contraintes1" name="contraintes[]" value="Hallal"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Hallal')) {echo 'checked';} ?>> Hallal
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="contraintes2" name="contraintes[]" value="Vegan"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Vegan'||$postdata['contraintes'][1]=='Vegan')) {echo 'checked';} ?>> Vegan
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="contraintes3" name="contraintes[]" value="Allergie"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Allergie'||$postdata['contraintes'][1]=='Allergie'||$postdata['contraintes'][2]=='Allergie')) {echo 'checked';} ?>> Allergie
            </label>

            <label class="col-xs-3">
                <input type="checkbox" id="contraintes4" name="contraintes[]" value="Casher"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Casher'||$postdata['contraintes'][1]=='Casher'||$postdata['contraintes'][2]=='Casher'||$postdata['contraintes'][3]=='Casher')) {echo 'checked';} ?>> Casher
            </label>
            <label class="col-xs-3">
                <input type="text" id="contraintes5" name="contraintes_autres" placeholder="i.e : La popote des potes"
                       value="<?php if (isset($postdata['contraintes_autres'])) {echo $postdata['contraintes_autres'];}?>">
            </label>
        </div>
    </div>

    <input type="submit" id="ajax_form_check" class="btn btn-primary" value="Je participe">

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

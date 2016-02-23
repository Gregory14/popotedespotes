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
    <div class="overlayContainer col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 ">

<h1>Votre cours de cuisine</h1>
        <div class="row">
<section class="col-lg-10 col-lg-offset-1">
    <h3>La recette</h3>
    <p>La popote des potes vous propose de construire les liens qui vous unissent à vos collaborateurs de façon ludique, responsable et solidaire. Pour travailler la cohésion d'équipe autrement, nous avons fait le choix de vous proposer un
        moment inoubliable d’échange et de partage au service de la solidarité. </p>
</section>
        </div>

        <section id="ingredients">

                    <h3>Les ingrédients</h3>
            <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="col-lg-10 col-lg-offset-1">
                            <h4>1 pincée de produits invendus</h4>
                            <p>Les produits que nous utilisons proviennent des invendus de petits producteurs locaux et
                                d’enseignes de la grande distribution.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="col-lg-10 col-lg-offset-1">
                            <h4 class="toqueIcon">l’expertise d’un chef renommé</h4>
                            <p>Nous apprenons à vos équipes à cuisiner des produits de saison et de manière responsable sous la
                                houlette de grands chefs.</p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-4">
                        <div class="col-lg-10 col-lg-offset-1">
                            <h4 class="panIcon">un camion entier de solidarité</h4>
                            <p>Nous nous engageons à reverser le fruit de votre journée de labeur à l’association caritative de
                                votre choix.</p>
                        </div>
                    </div>
            </div>
        </section>

<section>
    <h3>Le chef</h3>
    <h4>Thierry Marx</h4>
    <img src="img/homeMarx.jpg" alt="">
</section>

<form method="post" action="mon-cours.php?action=save" enctype="multipart/form-data" id="cours"
      class="form-horizontal">

    <?php
    if (isset($postdata) && isset($postdata['id']) && !empty($postdata['id']) ){
        ?>
        <input type="hidden" name="id" value="<?php echo $postdata['id'] ?>">
        <?php
    }else {?>
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <?php
    }
    ?>
    <section class="form-group has-feedback">

        <label for="menu" class="col-lg-12 control-label"><h3>Choix du menu</h3></label>

        <div class="">
            <label class="col-lg-4 col-md-4 col-sm-4">
                <input type="checkbox" id="menu1" name="menu[]" value="entrée"
                <?php if (isset($postdata['menu']) && $postdata['menu'][0]=='entrée') {echo 'checked';} ?>> <span>Entrée</span>
            </label>

            <label class="col-lg-4 col-md-4 col-sm-4">
                <input type="checkbox" id="menu2" name="menu[]" value="plat"
                <?php if (isset($postdata['menu']) && ($postdata['menu'][0]=='plat' || $postdata['menu'][1]=='plat')) {echo 'checked';} ?>> <span>Plats</span>
            </label>

            <label class="col-lg-4 col-md-4 col-sm-4">
                <input type="checkbox" id="menu3" name="menu[]" value="dessert"
                <?php if (isset($postdata['menu']) && (($postdata['menu'][0]) =='dessert' || $postdata['menu'][1] =='dessert' || $postdata['menu'][2] =='dessert')) {echo 'checked';} ?>> <span>Desserts</span>
            </label>
        </div>
    </section>

    <section class="form-group has-feedback">
        <label for="type_cuisine" class="col-lg-12 control-label"><h3>Type de cuisine</h3></label>

        <div class="col-lg-12">
            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img src="img/cookTrad.jpg">
                <input type="checkbox" id="type_cuisine1" name="type_cuisine[]" value="traditionelle"
                <?php if (isset($postdata['type_cuisine']) && $postdata['type_cuisine'][0]=='traditionelle') {echo 'checked';} ?>> <span>Cuisine traditionnelle</span>
            </label>

            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img src="img/cookWorld.jpg">
                <input type="checkbox" id="type_cuisine2" name="type_cuisine[]" value="monde"
                <?php if (isset($postdata['type_cuisine']) && ($postdata['type_cuisine'][0]=='monde'||$postdata['type_cuisine'][1]=='monde')) {echo 'checked';} ?>> <span>Cuisine du monde</span>
            </label>

            <label class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <img src="img/cookGastro.jpg">
                <input type="checkbox" id="type_cuisine3" name="type_cuisine[]" value="gastronomie"
                <?php if (isset($postdata['type_cuisine']) && ($postdata['type_cuisine'][0]=='gastronomie'||$postdata['type_cuisine'][1]=='gastronomie')||$postdata['type_cuisine'][2]=='gastronomie') {echo 'checked';} ?>> <span>Cuisine Gastonomique</span>
            </label>
        </div>
    </section>

    <section class="form-group has-feedback sectionAssos">
        <label for="association" class="col-lg-12 control-label"><h3>Pour qui cuisiner ?</h3></label>

        <div class="col-lg-12">
            <label class="col-lg-3 col-md-3 col-sm-3">
                <img src="img/homePauvres.jpg">
                <input type="checkbox" id="association1" name="association[]" value="les petits frère des pauvres"
                <?php if (isset($postdata['association']) && $postdata['association'][0]=='les petits frère des pauvres') {echo 'checked';} ?>> <span>Les petits frère des pauvres</span>
            </label>

            <label class="col-lg-3 col-md-3 col-sm-3">
                <img src="img/homeBanque.jpg">
                <input type="checkbox" id="association2" name="association[]" value="la banque alimentaire"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='la banque alimentaire'||$postdata['association'][1]=='la banque alimentaire')) {echo 'checked';} ?>> <span>La banque alimentaire</span>
            </label>

            <label class="col-lg-3 col-md-3 col-sm-3">
                <img src="img/homeArmee.jpg">
                <input type="checkbox" id="association3" name="association[]" value="armee du salut"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='armee du salut' || $postdata['association'][1]=='armee du salut' || $postdata['association'][2]=='armee du salut')) {echo 'checked';} ?>> <span></span>L'armee du salut</span>
            </label>

            <label class="col-lg-3 col-md-3 col-sm-3">
                <img src="img/homeRestos.jpg">
                <input type="checkbox" id="association4" name="association[]" value="les restaurants du coeur"
                <?php if (isset($postdata['association']) && ($postdata['association'][0]=='les restaurants du coeur' || $postdata['association'][1]=='les restaurants du coeur' || $postdata['association'][2]=='les restaurants du coeur')) {echo 'checked';} ?>> <span>Les restaurants du coeur</span>
            </label>
        </div>
    </section>

    <section class="form-group has-feedback">
        <label for="contraintes" class="col-lg-12 control-label"><h3>Mon cours</h3></label>
        <div></div>

        <div class="col-lg-12">
            <div class="doubleList col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-2 col-xs-12">
            <label class="col-lg-12 col-xs-12">
                <input type="checkbox" id="contraintes1" name="contraintes[]" value="Hallal"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Hallal')) {echo 'checked';} ?>> <span>Hallal</span>
            </label>

            <label class="col-lg-12 col-xs-12">
                <input type="checkbox" id="contraintes2" name="contraintes[]" value="Vegan"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Vegan'||$postdata['contraintes'][1]=='Vegan')) {echo 'checked';} ?>> <span>Vegan</span>
            </label>
            </div>

            <div class="doubleList col-lg-4 col-lg-offset-2 col-md-4 col-md-offset-2 col-sm-4 col-sm-offset-2 col-xs-12">
            <label class="col-lg-12 col-xs-12">
                <input type="checkbox" id="contraintes3" name="contraintes[]" value="Allergie"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Allergie'||$postdata['contraintes'][1]=='Allergie'||$postdata['contraintes'][2]=='Allergie')) {echo 'checked';} ?>> <span>Allergie</span>
            </label>

            <label class="col-lg-12 col-xs-12">
                <input type="checkbox" id="contraintes4" name="contraintes[]" value="Casher"
                <?php if (isset($postdata['contraintes']) && ($postdata['contraintes'][0]=='Casher'||$postdata['contraintes'][1]=='Casher'||$postdata['contraintes'][2]=='Casher'||$postdata['contraintes'][3]=='Casher')) {echo 'checked';} ?>> <span>Casher</span>
            </label>

                </div>
            <label class="col-lg-12 col-xs-12">
                <input type="text" id="contraintes5" name="contraintes_autres" placeholder="i.e : La popote des potes"
                       value="<?php if (isset($postdata['contraintes_autres'])) {echo $postdata['contraintes_autres'];}?>">
            </label>
        </div>
    </section>

    <input type="submit" id="ajax_form_check" class="btn" value="Je participe">

</form>
        </div>
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

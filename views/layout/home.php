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
<main>


    <section id="recette">
        <div class="container">
        <h3>La recette</h3>
        <p>Le bien être de votre entreprise passe avant tout par le bien être de vos salariés. Pour travailler la cohésion de vos équipes autrement, nous avons fait le choix de vous proposer un moment inoubliable d’échange et de partage au service de la solidarité. </p>
            </div>
    </section>

    <section id="ingredients">
        <div class="container">
            <div class="row">
        <h3>Les ingrédients</h3>
        <div class="col-lg-4">
           <h4>1 pincée de produits invendus</h4>
            <p>Les produits que nous utilisons proviennent des invendus de petits producteurs locaux et d’enseignes de la grande distribution.</p>
        </div>

        <div class="col-lg-4">
            <h4>l’expertise d’un chef renommé</h4>
            <p>Nous apprenons à vos équipes à cuisiner des produits de saison et de manière responsable sous la houlette de grands chefs.</p>
        </div>

        <div class="col-lg-4">
            <h4>un camion entier de solidarité</h4>
            <p>Nous nous engageons à reverser le fruit de votre journée de labeur à l’association caritative de votre choix.</p>
        </div>
                </div>
        <div class="row">
            <a href="reservation.php?action=edit" class="btn">Préparez votre popote</a>
        </div>
        </div>
    </section>

    <section id="partners">
        <div class="container">
            <div class="row">
            <div class="col-lg-4">
                <h3 class="rotatedTitle">Nous récupérons les invendus</h3>
            </div>
            <div class="col-lg-4">
                <article class="square">
                    <img src="/img/homeRungis.jpg">
                   <div class="details">
                       <h4>Rungis</h4>
                       <p></p>
                   </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="square">
                    <img src="/img/homeDistrib.jpg">
                    <div class="details">
                        <h4>Grande distribution</h4>
                        <p></p>
                    </div>
                </article>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-8">
                <article class="rectangle">
                    <img src="/img/homeAgriculteur.jpg">
                    <div class="details">
                        <h4>Producteurs locaux</h4>
                        <p></p>
                    </div>
                </article>
            </div>
            <div class="col-lg-4">
                <article class="square">
                    <img src="/img/homeRestaurateur.jpg">
                    <div class="details">
                        <h4>Restaurateurs</h4>
                        <p></p>
                    </div>
                </article>
            </div>
                </div>
        </div>
    </section>

    <section id="chefs">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3 class="rotatedTitle">Les chefs</h3>
                </div>
                <div class="col-lg-4">
                    <article class="square">
                        <img src="/img/homeMarx.jpg">
                        <div class="details">
                            <h4>Thierry Marx</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <article class="square">
                        <img src="/img/homeViola.jpg">
                        <div class="details">
                            <h4>Joseph Viola</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-4">
                    <article class="rectangle">
                        <img src="/img/homePourcel.jpg">
                        <div class="details">
                            <h4>Les frères Pourcel</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>


    <section id="associations">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <h3 class="rotatedTitle">Vous choisissez à qui vous reversez</h3>
                </div>
                <div class="col-lg-4">
                    <article class="square">
                        <img src="/img/homePauvres.jpg">
                        <div class="details">
                            <h4>Rungis</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <article class="square">
                        <img src="/img/homeBanque.jpg">
                        <div class="details">
                            <h4>Grande distribution</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                    <article class="square">
                        <img src="/img/homeArmee.jpg">
                        <div class="details">
                            <h4>Rungis</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
                <div class="col-lg-4">
                    <article class="square">
                        <img src="/img/homeRestos.jpg">
                        <div class="details">
                            <h4>Grande distribution</h4>
                            <p></p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>





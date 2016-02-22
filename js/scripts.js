$(function () {

    $(document).scroll(function () {


        //insère dans une variable la distance du haut de la page
        var $scroll = $(window).scrollTop();

        //Parallaxe sur l'image du haut
        $('figure img').css('transform', "translateY(" + ($scroll * 0.4) + "px)");

        //Fonctionnement du header : absolute, puis fixe, puis fond blanc
        if ($(this).scrollTop() > 40) {
            $('header').addClass('fixedHeader');
            if ($(this).scrollTop() > 785) {
                $('header').addClass('whiteHeader');
            } else {
                $('header').removeClass('whiteHeader');
            }
        } else {
            $('header').removeClass('fixedHeader');
        }

        //Fonctionnement du CTA : absolute, puis fixe, puis absolute
        var $barTop = $('.ctaContainer').offset().top;
        var $footerTop = $('footer').offset().top;
        if (($scroll) > ($barTop - $(window).height())) {
            $('.ctaContainer').addClass('ctaFixed');
            if (($scroll) > ($footerTop - $(window).height())) {
                $('.ctaContainer').addClass('bottomFixed');
                $('.ctaContainer').css('top',+ $footerTop-80);
            } else {
                $('.ctaContainer').removeClass('bottomFixed');
                $('.ctaContainer').css('top','');
            }
        } else{
        };
    });

    //Affichage / masquage du menu
    $('.menu-icon').click(function () {
        $('#main-menu').toggleClass('visible');
    });

    if ($('#recette')) {
        console.log('recette existe');
        $('body').removeClass('simpleHeader');
    } else {
        console.log('pas recette');
    }
});

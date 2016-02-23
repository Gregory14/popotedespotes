$(function () {
    $(window).trigger('scroll');

    //insère dans une variable la distance du haut de la page

    var $bodyClass = $('body').attr('class');

    var $imgUrl = "img/heroBackground.jpg";

    switch ($bodyClass){
        case 'contactform' :
            $imgUrl = "img/heroBackground2.jpg";
            break;
        case 'contactmerci' :
            $imgUrl = "img/heroBackground2.jpg";
            break;
        case 'coursform' :
            $imgUrl = "img/heroBackground3.jpg";
            break;
        case 'courscours' :
            $imgUrl = "img/heroBackground4.jpg";
            break;
        case 'courslist' :
            $imgUrl = "img/heroBackground4.jpg";
            break;
        case 'deviscommande' :
            $imgUrl = "img/heroBackground5.jpg";
            break;
        case 'devisform' :
            $imgUrl = "img/heroBackground5.jpg";
            break;
        case 'devislist' :
            $imgUrl = "img/heroBackground5.jpg";
            break;
        default :
            $imgUrl = "img/heroBackground.jpg";
    }
    $('figure').css('background-image','url('+ $imgUrl +')');





    //Affichage du figcaption sur la home seulement.
    $('figcaption').hide();
    $('.layouthome figcaption').show();

    $(document).scroll(function () {
        //Parallaxe sur l'image du haut

        var $scroll = $(window).scrollTop();
        $('figure').css('background-position', "center "+ ( -20 + ($scroll * 0.3))+"px");

        if($bodyClass == 'layouthome') {
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

        } else {
            if ($(this).scrollTop() > 40) {
                $('header').addClass('fixedHeader');
                    $('header').addClass('whiteHeader');
            } else {
                $('header').removeClass('fixedHeader');
            $('header').removeClass('whiteHeader');
            }
        }


    });

    //Affichage / masquage du menu
    $('.menu-icon').click(function () {
        $('#main-menu').toggleClass('visible');
    });

    //Scroll progressif sur les ancres
    $('a[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 1000);
                return false;
            }
        }
    });

});

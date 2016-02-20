$(function(){
    $(document).scroll(function(){

        var $scroll = $(window).scrollTop();
        $('figure img').css('transform',"translateY(" +  ($scroll * 0.4) + "px)");
        if($(this).scrollTop() > 40) {
            $('header').addClass('fixedHeader');
            if ($(this).scrollTop() > 785) {
                $('header').addClass('whiteHeader');
            } else {
                $('header').removeClass('whiteHeader');
            }
        } else {
            $('header').removeClass('fixedHeader');
            //$('figure img').css('transform',"translateY(0px)");
        }
    })

    $('.menu-icon').click(function(){
        $('#main-menu').toggleClass('visible');
    })
});

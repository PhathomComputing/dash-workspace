$(document).ready(function(){
    console.log("Search Loaded");
    var cmder = $('#commander-input');

    var navbar = $('#menu-bar');
    var button = $('.navbar-toggle');
    button.click(function(){
        if(navbar.hasClass('open')){
            navbar.removeClass('open');
            console.log('click');
            
            navbar.animate({height:'0px'},500,function(){
                navbar.css({'display':'none'});
            });
            
        } else {
            console.log('click');

            navbar.css({display:'block'});
            navbar.animate({height:'300px'},500);

            navbar.addClass('open');
        }
    });
});
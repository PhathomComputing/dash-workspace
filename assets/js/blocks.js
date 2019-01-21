

$('.block-head').click(function(){
    var block = $(this).parent();
    if(!block.attr('block-max')){
        block.attr('block-max',block.css('height'));
    }
    var currentH = block.css('height');
    var maxH = block.attr('block-max');
    console.log(parseInt(currentH));

    if(parseInt(currentH)>=20){ 
        block.animate({height:'17px'},500);
        console.log(parseInt(currentH));

    } else {
        block.animate({height:maxH },500);
        console.log(maxH);
    }
});
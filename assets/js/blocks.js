// $( function() {
//     $( ".block-dialog" ).dialog();
// } );

// $( function() {
//     $( ".block-menu-accord" ).accordion();
//   } );

$('.block-head').click(function(){
    var block = $(this).parent().parent().parent().parent();
    if(!block.attr('block-max')){
        block.attr('block-max',block.css('height'));
    }
    var currentH = block.css('height');
    var maxH = block.attr('block-max');
    console.log(parseInt(currentH));

    if(parseInt(currentH)>=80){ 
        block.animate({height:'17px'},500);
        console.log(parseInt(currentH));

    } else {
        block.animate({height:maxH },500);
        console.log(maxH);
    }
});

/**
 * You first need to create a formatting function to pad numbers to two digits…
 **/
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

/**
 * …and then create the method to output the date string as desired.
 * Some people hate using prototypes this way, but if you are going
 * to apply this to more than one Date object, having it as a prototype
 * makes sense.
 **/
Date.prototype.toMysqlFormat = function() {
    return this.getUTCFullYear() + "-" + twoDigits(1 + this.getUTCMonth()) + "-" + twoDigits(this.getUTCDate()) + " " + twoDigits(this.getUTCHours()) + ":" + twoDigits(this.getUTCMinutes()) + ":" + twoDigits(this.getUTCSeconds());
};


function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
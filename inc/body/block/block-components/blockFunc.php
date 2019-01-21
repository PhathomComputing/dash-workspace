<?php
   
    function setTitle($input){
        return "<div class='block-head'><dtitle class='".toSlug($input)."-block'>".$input."</dtitle></div>";
    }
    function imageThumb($imageUrl,$alt){
        return '<div class="thumbnail">
                    <img src="'.$imageUrl.'" alt="'.$alt.'" class="img-circle">
                </div><!-- /thumbnail -->';
    }
<?php 
function mbBlockStart(){
    return '<div class="col-sm-3 col-lg-3"><div class="dash-unit">';
}

function smBlockStart(){
    return'<div class="col-sm-3 col-lg-3"><div class="dash-unit half-unit">';
}
function smBlockMid(){
    return'</div><div class="half-unit dash-unit">';
}

function blockEnd(){
    return '</div></div>';
}

function optionBlock(){
    return '<div class="info-user">
    <span aria-hidden="true" class="li_user fs1"></span>
    <span aria-hidden="true" class="li_settings fs1"></span>
    <span aria-hidden="true" class="li_mail fs1"></span>
    <span aria-hidden="true" class="li_key fs1"></span>
    </div>';
}

function numberTicker($type){
    if($type==0){
        return '<div class="cont">
                    <p><bold>$879</bold> | <ok>Approved</ok></p>
                    <br>
                    <p><bold>$377</bold> | Pending</p>
                    <br>
                    <p><bold>$156</bold> | <bad>Denied</bad></p>
                    <br>
                    <p><img src="assets/img/up-small.png" alt=""> 12% Compared Last Month</p>
                </div>';
    } else {
        return "issue";
    }
}
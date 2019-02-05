<?php 
function mbBlockStart(){
    return '<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 block-flat"><div class="dash-unit block-flat">';
}
 
function smBlockStart(){
    return'<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3 block-flat"><div class="dash-unit half-unit block-flat">';
}
function smBlockMid(){
    return'</div><div class="half-unit dash-unit block-flat">';
}

function blockEnd(){
    return '</div></div>';
}

function blockDialog(){
    return '<div class="block-menu" title="Test">Test stuff</div>
    ';
}

function modalStart($id, $buttonClasses){
    $classes=' ';
    if(is_array($buttonClasses)){
        foreach ($buttonClasses as $key => $value){
            $classes.=$value.' ';
        }
    } else{
        $classes .= $buttonClasses;
    }
    return '
            <button type="button" class="btn'.$classes.'" data-toggle="modal" data-target="#'.$id.'">
                Launch
            </button>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <!-- Modal -->
            <div class="modal fade " id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Browser</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>';
}

function modalEnd(){
    return '
            </div>
            </div>
            </div>
            </div>';
}
function optionBlock(){
    return '<div class="info-user">
    <span aria-hidden="true" class="li_user fs1"></span>
    <span aria-hidden="true" class="li_settings fs1"></span>
    <span aria-hidden="true" class="li_mail fs1"></span>
    <span aria-hidden="true" class="li_key fs1"></span>
    </div>';
}

function whoisBlock(){
    return '
        <form action="" method="post">
        <input class="whois-input"
                style="margin:5px; width:90%;" 
                type="text" 
                name="whois_url"/>
        <input class="btn"
                style="font-size:.8em;padding:2px;margin-left:5px;margin-right:auto;position:relative;"
                type="submit" 
                name="SubmitButton"/>
    ';
}

function blockAccord(){
    return '<div class="menu-container"><div class="block-menu-accord">
    <h3>Section 1</h3>
    <div>
        <button>Test 1</button>
        <button>Test 2</button>
        <button>Test 3</button>
        <button>Test 4</button>
        <button>Test 5</button>
    </div>
    <h3>Section 2</h3>
    <div>
        <button>Test 1</button>
        <button>Test 2</button>
        <button>Test 3</button>
        <button>Test 4</button>
        <button>Test 5</button>
    </div>
    <h3>Section 3</h3>
    <div>
      <p>
      Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
      Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
      ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
      lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
      </p>
      <ul>
        <li>List item one</li>
        <li>List item two</li>
        <li>List item three</li>
      </ul>
    </div>
    <h3>Section 4</h3>
    <div>
      <p>
      Cras dictum. Pellentesque habitant morbi tristique senectus et netus
      et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
      faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
      mauris vel est.
      </p>
      <p>
      Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
      Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
      inceptos himenaeos.
      </p>
    </div>
  </div>
  </div>
   ';
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
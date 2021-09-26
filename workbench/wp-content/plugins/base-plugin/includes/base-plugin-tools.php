<?php 


function script_enqueuer() {
    wp_register_script( "base_plugin_scripts", plugin_dir_url(__FILE__).'/base_plugin_scripts.js', array('jquery') );
    wp_enqueue_script( 'base_plugin_scripts' );
    wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );


    wp_localize_script( 'base_plugin_scripts', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
}
 
 wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
function query_manager() {
    echo json_encode(array('response'=>'Connected!','payload'=>$_POST['task']));
    wp_die();
}

function please_login() {
    echo "You must log in";
    wp_die();
}
 

 add_action( 'init', 'script_enqueuer' );
 add_action("wp_ajax_query_manager", "query_manager");
 add_action("wp_ajax_nopriv_please_login", "please_login");
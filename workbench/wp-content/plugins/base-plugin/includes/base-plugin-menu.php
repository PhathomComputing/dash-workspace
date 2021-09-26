<?php
function base_plugin_menu()
{
    add_menu_page(
        'Base Plugin Settings',
        'Base Plugin',
        'manage_options',
        'base-plugin-settings',
        'base_plugin_settings',
        plugins_url( 'base-plugin/icon.png' ),
        100
    );

}
add_action( 'admin_menu', 'base_plugin_menu' );

function base_plugin_settings(){
    if(!current_user_can('manage_options')){
        return;
}

?>
        <script>
            function ajax_calls(task){
                var adata ={action: "query_manager",task:task};

                jQuery.ajax({
                    type : "post",
                    // dataType : "json",
                    url : './admin-ajax.php',
                    data : adata,
                    success: function(response) {
                        str = response.substring(response.length-5, response.length);
                        if(str.trim() == "NULL"){
                            response = response.substring(0, response.length-5);
                        }
                        response = JSON.parse(response);
                        console.log(response);
                        document.getElementById('timezone-note').innerHTML = response.response;
                            
                    },
                    error:function(response){
                        console.log("Issue connecting to action: ");
                        console.log("action: ");
                        console.log(response);
                        console.log(adata);
                    }
                });
            }
        </script>
        
         <div id="timezone-main-menu" >
            <div id="timezone-note" style="color:white;background-color:rgba(200,200,200,0.5);"></div>
            <div id="base-plugin-decoration" style="background-image:url('../wp-content/plugins/base-plugin/phathom.png');background-repeat:no-repeat;opacity:0.1;background-size:cover;height:1400px;background-color:rgba(0,0,0,1); border-radius:20px;position:absolute;width:100%;z-index:-100;"></div>
            <div class="container" style="background-color:rgba(200,200,200,0.5); border-radius:20px;padding:10px;">
                <div class="row">
                    <div class="col-12">
                    <h1><a href="http://localhost/root/1%20WordPress/Workbench2/wp-admin/admin.php?page=base-plugin-settings"><?php esc_html_e(get_admin_page_title());?></a></h1>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <p><?php esc_html_e('Step 1) Base Plugin Menu Content');?></p>
                
                        <form action="./admin.php" method="get">
                            <input type="hidden"   name="page" value="base-plugin-settings">
                            <input type="hidden" id="download" name="download" value="start">
                            <?php if(isset($_GET['download']) && isset($_SESSION['base-plugin-session'])){$_SESSION['base-plugin-session']->test_code();}?>
                            <button type="submit" value="Submit"  class="button">Step 1) Button Form 1</button>
                        </form>
                    </div>
                    <div class="col-sm-6">
                        <p><?php esc_html_e('Step 2) Base Plugin Menu Content');?></p>

                        <button  onclick="ajax_calls('test-ajax');"  class="button">Step 1) Button Ajax 1</button>
                    </div>
                </div>

            </div>
            
            
            
            
                
              
         </div>
        
                
    <?php
}


function looper(){
	while($_SESSION['base-plugin-session']->int_update()){
		gc_collect_cycles();
	}
	
	
}

function base_plugin_dropship_settings_add_settings_link($links){
    $settings_link = '<a href="admin.php?page=base-plugin-settings">'.__('Settings','base-plugin-settings').'</a>';
    array_push($links, $settings_link);
    return $links;
}

if($_SESSION['base-plugin-session']->debug_wwt){
    function onShutdown() {
        $error = error_get_last();
        var_dump($error);
        die;
    }
    register_shutdown_function("onShutdown");
}



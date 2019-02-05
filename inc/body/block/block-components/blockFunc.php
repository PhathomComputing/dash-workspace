<?php
   
    function setTitle($input){
        return "<div class='block-head'><dtitle class='".toSlug($input)."-block'>".$input."</dtitle></div>";
    }
    function imageThumb($imageUrl,$alt){
        return '<div class="thumbnail">
                    <img src="'.$imageUrl.'" alt="'.$alt.'" class="img-circle">
                </div><!-- /thumbnail -->';
    }

    function whois($domain) {
 
        // fix the domain name:
        $domain = strtolower(trim($domain));
        $domain = preg_replace('/^http:\/\//i', '', $domain);
        $domain = preg_replace('/^https:\/\//i', '', $domain);
        $domain = preg_replace('/^www\./i', '', $domain);
        $domain = explode('/', $domain);
        $domain = trim($domain[0]);
     
        // split the TLD from domain name
        $_domain = explode('.', $domain);
        

        $lst = count($_domain)-1;
        $ext = $_domain[$lst];
     
        // You find resources and lists 
        // like these on wikipedia: 
        //
        // http://de.wikipedia.org/wiki/Whois
        //
        $servers = array(
            "biz" => "whois.neulevel.biz",
            "com" => "whois.internic.net",
            "us" => "whois.nic.us",
            "coop" => "whois.nic.coop",
            "info" => "whois.nic.info",
            "name" => "whois.nic.name",
            "net" => "whois.internic.net",
            "gov" => "whois.nic.gov",
            "edu" => "whois.internic.net",
            "mil" => "rs.internic.net",
            "int" => "whois.iana.org",
            "ac" => "whois.nic.ac",
            "ae" => "whois.uaenic.ae",
            "at" => "whois.ripe.net",
            "au" => "whois.aunic.net",
            "be" => "whois.dns.be",
            "bg" => "whois.ripe.net",
            "br" => "whois.registro.br",
            "bz" => "whois.belizenic.bz",
            "ca" => "whois.cira.ca",
            "cc" => "whois.nic.cc",
            "ch" => "whois.nic.ch",
            "cl" => "whois.nic.cl",
            "cn" => "whois.cnnic.net.cn",
            "cz" => "whois.nic.cz",
            "de" => "whois.nic.de",
            "fr" => "whois.nic.fr",
            "hu" => "whois.nic.hu",
            "ie" => "whois.domainregistry.ie",
            "il" => "whois.isoc.org.il",
            "in" => "whois.ncst.ernet.in",
            "ir" => "whois.nic.ir",
            "mc" => "whois.ripe.net",
            "to" => "whois.tonic.to",
            "tv" => "whois.tv",
            "ru" => "whois.ripn.net",
            "org" => "whois.pir.org",
            "aero" => "whois.information.aero",
            "nl" => "whois.domain-registry.nl"
        );
        if (isset($servers[$ext])){
        
     
            $nic_server = $servers[$ext];
        
            $output = '';
        
            // connect to whois server:
            if ($conn = fsockopen ($nic_server, 43)) {
                fputs($conn, $domain."\r\n");
                while(!feof($conn)) {
                    $output .= fgets($conn,128);
                }
                fclose($conn);
                return $output;

            }
            else { 
                echo 'Error: Could not connect to ' . $nic_server . '!'; 
            }
        
        } else {
        return 0;
        }
    }

    function optionsBlock($option){
        if($option == "notice"){
        return '
                    <div class="switch">
                        <input type="radio" class="switch-input" name="view" value="on" id="on" checked="">
                        <label for="on" class="switch-label switch-label-off">On</label>
                        <input type="radio" class="switch-input" name="view" value="off" id="off">
                        <label for="off" class="switch-label switch-label-on">Off</label>
                        <span class="switch-selection"></span>
                    </div>';
        } else if($option == "info"){
            return '
            <div class="switch switch-blue">
                <input type="radio" class="switch-input" name="view2" value="week2" id="week2" checked="">
                <label for="week2" class="switch-label switch-label-off">Week</label>
                <input type="radio" class="switch-input" name="view2" value="month2" id="month2">
                <label for="month2" class="switch-label switch-label-on">Month</label>
                <span class="switch-selection"></span>
            </div>
            ';
        } else if($option == "warning"){
            return '
            <div class="switch switch-yellow">
                <input type="radio" class="switch-input" name="view3" value="yes" id="yes" checked="">
                <label for="yes" class="switch-label switch-label-off">Yes</label>
                <input type="radio" class="switch-input" name="view3" value="no" id="no">
                <label for="no" class="switch-label switch-label-on">No</label>
                <span class="switch-selection"></span>
            </div>';
        }
    }

  
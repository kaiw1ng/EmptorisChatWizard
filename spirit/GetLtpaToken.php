<?php
       $URL='https://sepilot.ssmcloud.com/emptoris/j_security_check';
        $req = curl_init(); 
        curl_setopt($req, CURLOPT_URL,            $URL );   
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);  
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($req, CURLOPT_POST,           true ); 
        $data = array('j_username' => 'kai', 'j_password' => 'win3demo');
        curl_setopt($req, CURLOPT_POSTFIELDS,    http_build_query($data));
        curl_setopt($req, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($req, CURLOPT_HEADER, 1);
        $resp	= curl_exec($req);
        curl_close($req);
        preg_match_all('/^Set-Cookie:\s*([^\r\n]*)/mi', $resp, $matches);
        //preg_match_all('/Set-Cookie: (.*)\b/', $resp, $matches);
        print_r($matches);
        $cookies = array();
        foreach ($matches[1] as $m) {
            list($name, $value) = explode('=', $m, 2);
            $cookies[$name] = $value;
        }
        print_r($cookies);
        $ltpaToken = $cookies["LtpaToken2"];
        $ltpaTokenCookieValue = $ltpaToken;
        print_r('$ltpaTokenCookieValue'.$ltpaTokenCookieValue);
       
       // print "LTPA" . $ltpaTokenCookieValue;
        $Response['LtpaToken'] 	= $ltpaTokenCookieValue;
        setcookie ('LtpaToken2', $ltpaTokenCookieValue,	time() + (86400 * 30),'/');
       
	echo json_encode($Response);

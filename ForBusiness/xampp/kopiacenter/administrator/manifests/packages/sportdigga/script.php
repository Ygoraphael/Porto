<?php
/**
 * @package     Crosstec Template Tools
 * @author      Markus Bopp
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
*/
class pkg_sportdiggaInstallerScript
{
    function preflight(){
        // try downloading and installing gantry 
        
        if(file_exists(JPATH_SITE.'/administrator/components/com_gantry/gantry.php')) return;
        
        jimport('joomla.filesystem.file');
        JClientHelper::setCredentialsFromRequest('ftp');
        
        $config   = JFactory::getConfig();
        $dlfile = 'http://crosstec.de/gantry.zip';
        $dlerror = true;
        $p_file = 'gantry.zip';

        $delete = $config->get('tmp_path').'/'.$p_file;
        if(JFile::exists($delete)){
            JFile::delete($delete);
        }
        
        // Download the package at the URL given
        
        // trying curl first
        if(function_exists('curl_init')){
            
            $fp = @fopen($config->get('tmp_path').'/'.$p_file, 'w');
            if($fp !== false){
                $ch = curl_init($dlfile);
                curl_setopt($ch, CURLOPT_FILE, $fp);
                $data = curl_exec($ch);
                curl_close($ch);
                fclose($fp);
                if(file_exists($config->get('tmp_path').'/'.$p_file)){
                    $dlerror = false;
                }
            }
        }
        
        // trying fsockopen next
        if($dlerror){
            $host = "crosstec.de"; 
            $target = "gantry.zip"; 
            $port = 80; 
            $timeout = 120; 
            $protocol = "HTTP/1.0"; 

            $fd = @fsockopen($host,$port,$errnum,$errstr,$timeout); 
            if(!is_resource($fd)) { 
                
            } else { 

                $br = "\r\n"; 
                $headers = "GET ".$target." ".$protocol.$br ; 
                $headers .= "Accept: image/jpeg".$br ; 
                $headers .= "Accept-Language: en-us".$br ; 
                $headers .= "Host: ".$host.$br ; 
                $headers .= "Connection: Keep-Alive".$br ; 
                $headers .= "User-Agent: Socket-PHP-browser 1.0".$br; 
                $headers .= "Referer: http://www.somesite.com".$br ; 
                $headers .= "X-Something: Hello from John".$br.$br; 

                @fputs($fd,$headers); 

                $contents = ""; 

                while (!feof($fd)) { 
                    $contents .= fgets($fd, 2048); 
                } 
            } 
            @fclose($fd); 
            if(isset($contents) && $contents){
                JFile::write($config->get('tmp_path').'/'.$p_file,$contents);
                $dlerror = false;
            }
        }
          
        // no curl, no fsockopen, last try
        if($dlerror){
            $p_file = JInstallerHelper::downloadPackage($dlfile);
        }
        
        // Was the package downloaded?
        if ($p_file)
        {
                $tmp_dest = $config->get('tmp_path');

                // Unpack the downloaded package file
                $package = JInstallerHelper::unpack($tmp_dest . '/' . $p_file);

                if ($package){
                    $installer = new JInstaller;
                    // Install the package
                    $installer->install($package['dir']);
                    
                    // Cleanup the install files
                    if (!is_file($package['packagefile']))
                    {
                            $config = JFactory::getConfig();
                            $package['packagefile'] = $config->get('tmp_path') . '/' . $package['packagefile'];
                    }

                    JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);
                }
        }
        
        if(!file_exists(JPATH_SITE.'/administrator/components/com_gantry/gantry.php')){
            
            echo '<div style="background-color: red; background-color: rgba(255,0,0,0.3); border-radius: 8px;font-size: 18px;margin: 20px;padding: 20px;">
                    Note: Please download and install the Gantry Framework extension <a href="http://crosstec.de/gantry.zip">from here</a> in order to complete the installation. The template won\'t work properly until this extension has been installed.
                 </div>';
            
        }
        
    }
    
    function postflight(){
        
        
    }
    
    function install($parent) {
        
    }
    
    function update($parent) {
    }
    
    function uninstall($parent) { 
    }
}

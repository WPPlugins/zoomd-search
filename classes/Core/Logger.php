<?php
namespace Zoomd\Core;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

use Zoomd\Core\Settings;
const defaultloglevel = 1;

class Logger
    {
        
        public $logLevel = 1; //0=info , 1=Warn , 2=Error

        public function __construct(){                        
            $this->logLevel = defaultloglevel;            
            $lvl = get_transient('zoomd_loglevel');                                   
            if(isset($lvl) && is_numeric($lvl))
            {                    
                $this->logLevel = $lvl;                
            }  
        }

        public function Info($msg){            
            if($this->logLevel == 0)
                $this->log($msg,"Info");
        }

        public function Warn($msg){
            if($this->logLevel <= 1)
                $this->log($msg,"Warn");
        }

        public function Error($msg){
            if($this->logLevel <= 2)
                $this->log($msg,"Error");        
        }

        public function log($msg,$level = "Info")
        {
            try
            {
                $data_string = $msg;
                if(!$this->isJson($msg))
                {
                    $data = array("message" => $msg, "level" => $level);                                                                    
                    $data_string = json_encode($data);                  
                }
                $data_string = $this->enrichlogmsg($data_string);

                $this->post_async(logglyUrl,$data_string);

                $siteUrl = Settings::siteUrl();
                if(defined( 'Zoomd_DBG' )  && (substr($siteUrl,0,strlen(localhost)) == localhost))
                {
                    error_log($data_string);                    
                }
                //     $this->post_async(localLogUrl, $data_string);
            }
            catch (Exception $e) 
	        {
                
            }
        }

        private function post_async($url, $post_string)
        {
            //echo $post_string;
            $parts=parse_url($url);

            $fp = fsockopen($parts['host'],
                isset($parts['port'])?$parts['port']:80,
                $errno, $errstr, 30);

            $out = "POST ".$parts['path']." HTTP/1.1\r\n";
            $out.= "Host: ".$parts['host']."\r\n";
            $out.= "Content-Type: application/json\r\n";
            $out.= "Content-Length: ".strlen($post_string)."\r\n";
            $out.= "Connection: Close\r\n\r\n";
            if (isset($post_string)) $out.= $post_string;

            fwrite($fp, $out);
            fclose($fp);
        }

        private function enrichlogmsg($msg)
        {
            $jsonobj = json_decode($msg);
            $jsonobj->siteid = Settings::siteId();
            $jsonobj->url = Settings::siteUrl();
            $jsonobj->clientid = Settings::clientId();
            $jsonobj->lastindexed = Settings::lastIndex();
            $jsonobj->environment = Settings::environment();
            $jsonobj->email = Settings::email();

            return json_encode($jsonobj);
        }

        private function isJson($string) {
           return ((is_string($string) &&
            (is_object(json_decode($string)) ||
            is_array(json_decode($string))))) ? true : false;
        }

       
    }
?>
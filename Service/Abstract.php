<?php

class Service_Abstract
{
    protected $_host;
    protected $_httpHeader;

    /**
     * construct method
     */
    public function __construct()
    {
    }
    
	/**
	*
	* @param string $postFields service parameters
	* @return string service response
	*/
    protected function makeRequest($postFields = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_host);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        if($postFields) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        }

        if($this->_httpHeader) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->_httpHeader);
        }
        
        $answer = curl_exec($ch);
        curl_close($ch);

        return $answer;
    }
    
    /**
	*
	* @param array $postFields service parameters
	* @return xml response
	*/
    protected function makeXMLRequest($postFields = null)
    {
    	return simplexml_load_file(sprintf($this->_host,  $postFields[0] . ', ' . $postFields[1]));       
    }

}
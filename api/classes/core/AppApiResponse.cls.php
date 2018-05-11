<?php
namespace Api\Classes\Core;

class AppApiResponse
{
    CONST RESPONSE_JSON = '';
    CONST RESPONSE_HTML = '';
    CONST RESPONSE_XML  = '';

    private $httpResponseHeader;
    private $responseType;
    private $encoding;
    private $responseSubject;
    private $responseItems;
    /**
     * Format should be like 
     * responseType     => 'Data type of response e.g.json,html,xml'
     * responseSubject  => 'what is the reponse for e.g. checkerResult'
     * responseItem     => 'response item'
     * responseResult   => 'response result, free format'
    */

    public function __construct($subject ="", $type = 'JSON' ,$encoding='utf8')
    {
        $this->responseType     = $type;
        $this->encoding         = $encoding;
        $this->responseSubject  = $subject;
        $this->responseItems    = [];
        return $this;
    }//end method __construct

    public function send()
    {   ob_start();
        ob_end_flush();
    }//end method

    public function addResponse($response)
    {
        array_push($this->httpResponseHeader,$response);
    }//end method

}//end class AppApiResponse

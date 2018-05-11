<?php
if(isset($_GET['type']) && isset($_GET['index'])){                                                                                               
    $data_string = '{
        "apiObj":"AppMain",
        "apiObjMethod":"appClientScriptLoader",
        "showMainView":true,
        "jwtToken":"j142hu412iu4joi12u81724",
        "csrfToken":"userSupportInquiry",
        "apiObjData":
            {"data":
                {
                    "type":"'.$_GET['type'].'",
                    "index":"'.$_GET['index'].'"
                }
            },
        "apiShowUI":false
    }';

    $ch = curl_init('http://localhost/ExternalProjects/WrightAgency/index.php');                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER,  [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string)
    ]);                                                                                                                   
                                                                                                                        
    $result = curl_exec($ch);
    if($_GET['type'] == 'js'){
        header('Content-type: application/javascript');
    }else{
        header('Content-type: text/css; charset: UTF-8');
    }//end method 
    print $result;
}
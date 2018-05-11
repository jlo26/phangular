<?php
                                                                                                                     
$data_string = '{"apiObj":"App001","jwtToken":"j142hu412iu4joi12u81724","csrfToken":"userSupportInquiry","apiObjData":{"data":{"fname":"Jerold","lname":"Lozares","email":"eqw","phone":"321","subject":"sds","message":"Help my tanong ako mr dj"},"":""},"apiObjMethod":"userFormCtrl","apiShowUI":true}';
//$data_string = '{"apiObj":"App001","jwtToken":"j142hu412iu4joi12u81724","csrfToken":"312312312312","apiObjData":{"data":{"fname":"Jerold","lname":"Lozares","email":"eqw","phone":"321","subject":"sds","message":"Help my tanong ako mr dj"},"":""},"apiObjMethod":"","apiShowUI":true}';
$ch = curl_init('http://localhost/ExternalProjects/WrightAgency/index.php');                                                                      
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);

print $result;
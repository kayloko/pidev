<?php
/*
This call sends a message based on a template.
*/

namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;





class Mail {

private $api_key="32ea0c74f44f4f1eb227675e31c96382";
private $api_key_private="faf50c839fdba0743dd712c9992f6fb7";


public function send($emailTo,$nom,$subject,$content) {


$mj = new Client($this->api_key,$this->api_key_private,true,['version' => 'v3.1']);


   
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "mouhamedaziz.jribi@esprit.tn",
                    'Name' => "Mailjet Pilot"
                ],
                'To' => [
                    [
                        'Email' => $emailTo,
                        'Name' => $nom
                    ]
                ],
                'TemplateID' => 3717798,
                'TemplateLanguage' => true,
                'Subject' => $subject, 
                'Variables' => [
                    "content" => $content,
                ]
            ]
        ]
    ];
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    $response->success();
    
    

}


}
?>
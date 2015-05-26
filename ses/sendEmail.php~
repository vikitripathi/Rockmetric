<?php
// session_start();
require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\Ses\SesClient;

use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('*********************', '************************');

// Instantiate the S3 client with your AWS credentials
$client = SesClient::factory(array(//calling function using namespace
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));


// use an AWS SDK to send email through Amazon SES if you want to call the Amazon SES API,
// but you do not want to handle low-level details such as assembling and parsing HTTP requests and responses.



$subject='SES Testing';
$data='My Plain Text';
$htmlData='<b>my html email</b>';
$from='abhishekdutt.iitr@gmail.com';
$to='duttabhishekb209@gmail.com';

// $client = $aws->get('Ses');
// create a client object to be able to send the mail

//The unique message identifier returned from the SendEmail action.
$MessageId = $client->sendEmail(array(
    // Source is required
    'Source' => $from, //from@gmail.com
    // Destination is required
    'Destination' => array(
        'ToAddresses' => array($to),//to@gmail.com
        // 'CcAddresses' => array('string', ... ),
        // 'BccAddresses' => array('string', ... ),
    ),
    // Message is required
    'Message' => array(
        // Subject is required
        'Subject' => array(
            // Data is required
            'Data' => $subject,//SES  testing
            'Charset' => 'UTF-8',//UTF-8
        ),
        // Body is required
        'Body' => array(
            'Text' => array(
            	//The content of the message, in text format. Use this for text-based email clients,
            	// or clients on high-latency networks (such as mobile devices).
                // Data is required
                'Data' => $data,//my plain text
                'Charset' => 'UTF-8',//UTF-8
            ),
            'Html' => array(
            	//The content of the message, in HTML format. Use this for email clients that can process 
            	//HTML. You can include clickable links, formatted text, and much more in an HTML message.
                // Data is required
                'Data' => $htmlData,//<b>my html email</b>
                'Charset' => 'UTF-8',//UTF-8
            ),
        ),
    ),
    'ReplyToAddresses' => array('abhishekdutt.iitr@gmail.com' ),//replyto@gmail.com
    //The email address to which bounces and complaints are to be forwarded when feedback forwarding is enabled.
    'ReturnPath' => 'abhishekdutt.iitr@gmail.com',//bounce@email.com
));


echo "            ______________________________________________________________________        </br></br>        ";
print_r($MessageId);
echo " <br> <br> ";

?>

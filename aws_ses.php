<?php

require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\Ses\SesClient;
use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('AKIAJJ3WVG5MZE5FRSTQ', 'nChpEQQFDdq5DviCON7lv+kMT6n0oqu/xo4qLV63');

// Instantiate the S3 client with your AWS credentials
$client = SesClient::factory(array(
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));



// Create the AWS service builder, providing the path to the config file
// $aws = Aws::factory('config.php');






// $client = $aws->get('Ses');
// create a client object to be able to send the mail

//The unique message identifier returned from the SendEmail action.
$MessageId = $client->sendEmail(array(
    // Source is required
    'Source' => 'abhishekdutt.iitr@gmail.com', //from@gmail.com
    // Destination is required
    'Destination' => array(
        'ToAddresses' => array('duttabhishekb209@gmail.com' ),//to@gmail.com
        // 'CcAddresses' => array('string', ... ),
        // 'BccAddresses' => array('string', ... ),
    ),
    // Message is required
    'Message' => array(
        // Subject is required
        'Subject' => array(
            // Data is required
            'Data' => 'SES Testing',//SES  testing
            'Charset' => 'UTF-8',//UTF-8
        ),
        // Body is required
        'Body' => array(
            'Text' => array(
            	//The content of the message, in text format. Use this for text-based email clients,
            	// or clients on high-latency networks (such as mobile devices).
                // Data is required
                'Data' => 'My Plain Text',//my plain text
                'Charset' => 'UTF-8',//UTF-8
            ),
            'Html' => array(
            	//The content of the message, in HTML format. Use this for email clients that can process 
            	//HTML. You can include clickable links, formatted text, and much more in an HTML message.
                // Data is required
                'Data' => '<b>my html email</b>',//<b>my html email</b>
                'Charset' => 'UTF-8',//UTF-8
            ),
        ),
    ),
    'ReplyToAddresses' => array('abhishekdutt.iitr@gmail.com' ),//replyto@gmail.com
    //The email address to which bounces and complaints are to be forwarded when feedback forwarding is enabled.
    'ReturnPath' => 'abhishekdutt.iitr@gmail.com',//bounce@email.com
));

print_r($client->listVerifiedEmailAddresses());
echo "            ______________________________________________________________________        </br></br>        ";
print_r($MessageId);


$FeedbackForwardingObject = $client->setIdentityFeedbackForwardingEnabled(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // ForwardingEnabled is required
    'ForwardingEnabled' => true,
    //false specifies that Amazon SES will publish bounce and complaint notifications only through Amazon SNS
    //This value can only be set to false when Amazon SNS topics are set for both Bounce and Complaint notification types.
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($FeedbackForwardingObject);
/*
Given an identity (email address or domain), sets the Amazon Simple Notification Service (Amazon SNS) topic to which Amazon SES 
will publish bounce, complaint, and/or delivery notifications for emails sent with that identity as the Source .
 */

$ComplaintNotificationObject = $client->setIdentityNotificationTopic(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // NotificationType is required
    'NotificationType' => 'Complaint',//	Bounce | Complaint | Delivery
    // 'SnsTopic' => 'string',
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($ComplaintNotificationObject);


$BounceNotificationObject = $client->setIdentityNotificationTopic(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // NotificationType is required
    'NotificationType' => 'Bounce',//    Bounce | Complaint | Delivery
    // 'SnsTopic' => 'string',
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($BounceNotificationObject);

$AttributeObject = $client->getIdentityNotificationAttributes(array(
    // Identities is required
    'Identities' => array('abhishekdutt.iitr@gmail.com'),
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($AttributeObject);

?>
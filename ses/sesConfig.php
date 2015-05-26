<?php
session_start();
require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\Ses\SesClient;

use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('*********************', '************************');

// Instantiate the SES client with your AWS credentials
$client = SesClient::factory(array(//calling function using namespace
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));


//create configuration using SDK 
//Before you can send an email using Amazon SES,
//you must verify the address or domain that you are sending the email from to prove that you own it



//create  an email identity Manually


//verify an email address
//Verifies an email address. This action causes a confirmation email message to be sent to the specified address
//other related functions
//ListIdentities
//GetIdentityVerificationAttributes
$result_verifyEmailId = $client->verifyEmailIdentity(array(
    // EmailAddress is required
    'EmailAddress' => 'abhishekdutt.iitr@gmail.com',
));

// //use  GetIdentityVerificationAttributes to get the status of the email address that is it ready to perofrm the next sending operations?
$result_verificationStatus = $client->getIdentityVerificationAttributes(array(
    // Identities is required
    'Identities' => array('abhishekdutt.iitr@gmail.com',),
));



//Authentication

//manage Easy DKIM in AWS SES
$result_DKIMtokens = $client->verifyDomainDkim(array(
    // Domain is required
    'Domain' => 'rockmetric.com',
));
//Returns a set of DKIM tokens for a domain
// DKIM tokens are character strings that represent your domain's 
//identity. Using these tokens, you will need to create DNS CNAME records that point to DKIM public keys hosted by Amazon SES.
print_r($result1);
echo "  <br/> ";
print_r($result1['DkimTokens'][0]);
echo " <br>";
//below are the TOken Names & corresponding values to be used in updating DNS setting using AWS Route53
//store them in session to be used  in the route53Config.php file
//set session variable
$_SESSION["value1"]=$result1['DkimTokens'][0].".dkim.amazonses.com";
$_SESSION["name1"]=$result1['DkimTokens'][0]."._domainkey .rockmetric.com.";

$_SESSION["value2"]=$result1['DkimTokens'][1].".dkim.amazonses.com";
$_SESSION["name2"]=$result1['DkimTokens'][1]."._domainkey .rockmetric.com.";

$_SESSION["value3"]=$result1['DkimTokens'][2].".dkim.amazonses.com";
$_SESSION["name3"]=$result1['DkimTokens'][2]."._domainkey .rockmetric.com.";
//the above session variables can be simplified by doing the concatination in the route53Config.php

echo $_SESSION["value1"]."  <---  ".$_SESSION["name1"];

echo " <br> <br> ______________________________________________________________________ <br>";


/*
returns the following information for each:

Whether Easy DKIM signing is enabled or disabled.
A set of DKIM tokens that represent the identity. If the identity is an email address, the tokens represent the domain of that address.
Whether Amazon SES has successfully verified the DKIM tokens published in the domain's DNS. This information is only returned for domain
name identities, not for email addresses.
*/
$result_DKIM_attribute = $client->getIdentityDkimAttributes(array(
    // Identities is required
    'Identities' => array('rockmetric.com',),
));
print_r($result_DKIM_attribute);
//check by  above whether dkim is verified or not then go to next step


//Enables or disables Easy DKIM signing of email sent from an identity:
//run the below ,if  Domain is verified for DKIM signing, to enable DKIM signing
// $result_DKIM_enable = $client->setIdentityDkimEnabled(array(
//     // Identity is required
//     'Identity' => 'abhishekdutt.iitr@gmail.com',
//     // DkimEnabled is required
//     'DkimEnabled' => true,//true || false
// ));

echo " <br> <br> ";


print_r($client->listVerifiedEmailAddresses());
echo "            ______________________________________________________________________        </br></br>        ";


/*
Given an identity (email address or domain), sets the Amazon Simple Notification Service (Amazon SNS) topic to which Amazon SES 
will publish bounce, complaint, and/or delivery notifications for emails sent with that identity as the Source .
 */

$ComplaintNotificationObject = $client->setIdentityNotificationTopic(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // NotificationType is required
    'NotificationType' => 'Complaint',//	Bounce | Complaint | Delivery
    'SnsTopic' => 'ses-complaint',
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($ComplaintNotificationObject);
echo " <br> <br> ";

$BounceNotificationObject = $client->setIdentityNotificationTopic(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // NotificationType is required
    'NotificationType' => 'Bounce',//    Bounce | Complaint | Delivery
    'SnsTopic' => 'ses-bounce',
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($BounceNotificationObject);
echo " <br> <br> ";

$DeliveryNotificationObject = $client->setIdentityNotificationTopic(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // NotificationType is required
    'NotificationType' => 'Delivery',//    Bounce | Complaint | Delivery
    'SnsTopic' => 'ses-delivery',
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($DeliveryNotificationObject);
echo " <br> <br> ";

$AttributeObject = $client->getIdentityNotificationAttributes(array(
    // Identities is required
    'Identities' => array('abhishekdutt.iitr@gmail.com'),
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($AttributeObject);
echo " <br> <br> ";

$FeedbackForwardingObject = $client->setIdentityFeedbackForwardingEnabled(array(
    // Identity is required
    'Identity' => 'abhishekdutt.iitr@gmail.com',
    // ForwardingEnabled is required
    'ForwardingEnabled' => false,
    //false specifies that Amazon SES will publish bounce and complaint notifications only through Amazon SNS
    //This value can only be set to false when Amazon SNS topics are set for both Bounce and Complaint notification types.
));
echo "            ______________________________________________________________________        </br></br>        ";
print_r($FeedbackForwardingObject);





echo "______________________________________ <br/>";
print_r($client->getSendStatistics());
?>

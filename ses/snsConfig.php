<?php

require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\Sns\SnsClient;
use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('*********************', '************************');

// Instantiate the S3 client with your AWS credentials
$client = SnsClient::factory(array(
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));


/*
Create topics
*/

$result_bounce = $client->createTopic(array(
    // Name is required
    'Name' => 'ses-bounce',
));
//returns topic ARN
print_r($result_bounce['TopicArn']);
$bounce_TopicArn=$result_bounce['TopicArn'];
//print_r to see how to access arn

$result_delivery = $client->createTopic(array(
    // Name is required
    'Name' => 'ses-delivery',
));
$delivery_TopicArn=$result_delivery['TopicArn'];
//returns topic ARN
//print_r to see how to access arn

$result_complaint = $client->createTopic(array(
    // Name is required
    'Name' => 'ses-complaint',
));
$complaint_TopicArn=$result_complaint['TopicArn'];
//returns topic ARN
//print_r to see how to access TOPIC ARN



/*
Subscribe topic
*/
//Prepares to subscribe an endpoint by sending the endpoint a confirmation message
$subscribe_bounce = $client->subscribe(array(
    // TopicArn is required
    'TopicArn' => $bounce_TopicArn,
    // Protocol is required
    'Protocol' => 'http',
    'Endpoint' => 'http://52.11.216.77/receiver.php',
));
//returns subscription arn

$subscribe_delivery = $client->subscribe(array(
    // TopicArn is required
    'TopicArn' => $delivery_TopicArn,
    // Protocol is required
    'Protocol' => 'http',
    'Endpoint' => 'http://52.11.216.77/receiver.php',
));


$subscribe_complaint = $client->subscribe(array(
    // TopicArn is required
    'TopicArn' => $complaint_TopicArn,
    // Protocol is required
    'Protocol' => 'http',
    'Endpoint' => 'http://52.11.216.77/receiver.php',
));


//after subscription has been done
//takes some time

//$subscriptionList = $client->listSubscriptions(array());








?>

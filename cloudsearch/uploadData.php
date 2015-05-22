<?php

require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\CloudSearch\CloudSearchClient;
use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('AKIAJGNXPG7B5Z7D2XNQ', '7BnCTRL/k2XH4/NHn22HdxbnwDCL/DM81MjWZsBR');

$client = CloudSearchClient::factory(array(
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));
//use OOP  to simplify the issue of reusing the credential on each page!

//******do the below after the status is active! ******
//if clause with domaindescribe() return values of the current status

//get the domain endpoint
$domain=$client->getDomainClient('people2',array(
    'credentials' => $credentials,
    ));


//document batches to be uploaded to cloudsearch
//*check about escaping all double quotes within the string
//get the data from a JSON stream
$jsonData = '[ {
  "type" : "add",
  "id" : "data.csv1",
  "fields" : {
    "email" : "abhishek09011993@gmail.com",
    "name" : "abhishekoldest",
    "user_id" : 1234,
    "telephone" : 7379695255
  }
}, 
{
  "type" : "add",
  "id" : "data.csv2",
  "fields" : {
    "email" : "duttabhishekb209@gmail.com",
    "name" : "abhishekolder",
    "user_id" : 1235,
    "telephone" : 9878768797
  }
}, 
{
  "type" : "add",
  "id" : "data.csv3",
  "fields" : {
    "email" : "abhishekdutt.iitr@gmail.com",
    "name" : "abhishekold",
    "user_id" : 1236,
    "telephone" : 8979079799
  }
} ]';

//upload the document batches
$result_uploadDocuments=$domain->uploadDocuments(array(
    'documents'=>$jsonData,
    'contentType'=>'application/json'
    ));


?>
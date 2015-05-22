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



//get the domain endpoint
$domain=$client->getDomainClient('people2',array(
    'credentials' => $credentials,
    ));



//retrieve suggestions by sending requests to the "suggest" resource on a domain's search endpoint via HTTP GET
//http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2012-10-17/suggest?q=

$curl = curl_init();

$url="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/suggest?q=abhishek&suggester=mysuggester";
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url,    
));
$result_curlSuggest = curl_exec($curl);
curl_close($curl);
print_r($result_curlSuggest);


?>
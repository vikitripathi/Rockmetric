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




//******do the below after the status is active! ******
//if clause with domaindescribe() return values

//get the domain endpoint
$domain=$client->getDomainClient('people2',array(
    'credentials' => $credentials,
    ));



// Use the search operation 
$result_search = $domain->search(array('query' => 'abhishekolder'));   
$hitCount = $result_search->getPath('hits/hit'); //hits/hit for the document that is found
print_r($hitCount); 



?>
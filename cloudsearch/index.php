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

//create a new search domain
$result1 = $client->createDomain(array(
    // DomainName is required
    'DomainName' => 'people',
));


//configure access
$policy_json='{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Sid": "",
      "Effect": "Allow",
      "Principal": {
        "AWS": "*"
      },
      "Action": [
        "cloudsearch:suggest",
        "cloudsearch:search"
      ]
    }
  ]
}';

$result_access = $client->updateServiceAccessPolicies(array(
    // DomainName is required
    'DomainName' => 'people',
    // AccessPolicies is required
    'AccessPolicies' => $policy_json, //what should it be?
));


//configure scaling option
$result_scaling = $client->updateScalingParameters(array(
    // DomainName is required
    'DomainName' => 'people',
    // ScalingParameters is required
    'ScalingParameters' => array(
        'DesiredInstanceType' => 'search.m1.small',
        'DesiredReplicationCount' => 1,
        // 'DesiredPartitionCount' => integer,
    ),
));


//configure avaliability options
$result_availability = $client->updateAvailabilityOptions(array(
    // DomainName is required
    'DomainName' => 'people',
    // MultiAZ is required
    'MultiAZ' => true,//write any one either true or false!
));


//domain information
$result_domainInfo = $client->describeDomains(array(
    'DomainNames' => array('people'),
));



//list domains
// $iterator = $client->getIterator('DescribeDomains');
// foreach ($iterator as $domain) {
//     echo "{$domain['DomainName']}: {$domain['SearchService']['Endpoint']}\n";
// }



//prepare data to be uploaded for cloudsearch 

//configure the index fields
$result_indexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'name',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            'SourceField' => 'name',
            'ReturnEnabled' => true,
            'SortEnabled' => true,
            'HighlightEnabled' => true, 
            'AnalysisScheme' => 'English',
        ),        
    ),
    'IndexField'=>array(
    	// IndexFieldName is required
        'IndexFieldName' => 'email',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            'SourceField' => 'email',
            'ReturnEnabled' => true,
            'SortEnabled' => true,
            'HighlightEnabled' => true,
            'AnalysisScheme' => 'English',
        ), 
    ),
    'IndexField'=>array(
    	// IndexFieldName is required
        'IndexFieldName' => 'telephone',
        // IndexFieldType is required
        'IndexFieldType' => 'int',
        'IntOptions' => array(            
            'SourceField' => 'telephone',
            'FacetEnabled' => true,
            'SearchEnabled' => true,
            'ReturnEnabled' => true,
            'SortEnabled' => true,
        ),
    ),
    'IndexField'=>array(
    	// IndexFieldName is required
        'IndexFieldName' => 'user_id',
        // IndexFieldType is required
        'IndexFieldType' => 'int',
    	'IntOptions' => array(            
            'SourceField' => 'user_id',
            'FacetEnabled' => true,
            'SearchEnabled' => true,
            'ReturnEnabled' => true,
            'SortEnabled' => true,
        ),
    ),
));



//Every document must have a unique document ID and at least one field.
//uploading the data/document usin http endpoint
//getdomainclient  method uses the CloudSearch configuration API to retrieve the domain endpoint and instantiate the CloudSearchDomainClient 

$domain=$client->getDomainClient('people',array(
    'credentials' => $credentials,
    ));

//document batches to be uploaded to cloudsearch
$jsonData = '[ {
  "type" : "add",
  "id" : "data.csv_1",
  "fields" : {
    "email" : "abhishek09011993@gmail.com",
    "name" : "abhishekoldest",
    "user_id" : "1234",
    "telephone" : "7379695255"
  }
}, {
  "type" : "add",
  "id" : "data.csv_2",
  "fields" : {
    "email" : "duttabhishekb209@gmail.com",
    "name" : "abhishekolder",
    "user_id" : "1235",
    "telephone" : "9878768797"
  }
}, {
  "type" : "add",
  "id" : "data.csv_3",
  "fields" : {
    "email" : "abhishekdutt.iitr@gmail.com",
    "name" : "abhishekold",
    "user_id" : "1236",
    "telephone" : "8979079799"
  }
} ]';

$result6=$domain->uploadDocuments(array(
    'documents'=>$jsonData,
    'contentType'=>'application/json'
    ));


//if some changes to index of the document then uncomment  and run for confguring indexing again
// $result8 = $client->indexDocuments(array(
//     // DomainName is required
//     'DomainName' => 'string',
// ));


//left api searching /  suggesting / analytics


?>
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





//json to be  passed to updateServiceAccessPolicies
//*check about escaping all double quotes within the string
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

//configure access policy
$result_access = $client->updateServiceAccessPolicies(array(
    // DomainName is required
    'DomainName' => 'people',
    // AccessPolicies is required
    'AccessPolicies' => $policy_json, 
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
    'MultiAZ' => true,
));


//domain information
$result_domainInfo = $client->describeDomains(array(
    'DomainNames' => array('people'),
));




//prepare data to be uploaded for cloudsearch 

//configure the index fields
$result_nameIndexField = $client->defineIndexField(array(
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
));

$result_emailIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
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
));


$result_telephoneIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
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
));

$result_userIdIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
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



//configuring the analysis scheme
$result_analysisScheme = $client->defineAnalysisScheme(array(
    // DomainName is required
    'DomainName' => 'people',
    // AnalysisScheme is required
    'AnalysisScheme' => array(
        // AnalysisSchemeName is required
        'AnalysisSchemeName' => 'myscheme',
        // AnalysisSchemeLanguage is required
        'AnalysisSchemeLanguage' => 'en', 
        'AnalysisOptions' => array(
            // 'Synonyms' => 'string',
            'Stopwords' => '["a", "an", "the", "of"]', //*check about escaping all double quotes within the string
            // 'StemmingDictionary' => 'string',
            // 'JapaneseTokenizationDictionary' => 'string',
            'AlgorithmicStemming' => 'light',
        ),
    ),
));


//updating the index field with the analysis scheme
$update_nameIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'name',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            'AnalysisScheme' => 'myscheme',//myscheme
        ),        
    ),    
));

$update_emailIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'email',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            'AnalysisScheme' => 'myscheme',//myscheme
        ),        
    ), 
));


//rebuilding the index
$rebuildingIndexScheme = $client->indexDocuments(array(
    // DomainName is required
    'DomainName' => 'string',
));




//get the domain endpoint
$domain=$client->getDomainClient('people',array(
    'credentials' => $credentials,
    ));


//document batches to be uploaded to cloudsearch
//*check about escaping all double quotes within the string
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

//upload the document batches
$result_uploadDocuments=$domain->uploadDocuments(array(
    'documents'=>$jsonData,
    'contentType'=>'application/json'
    ));



// Use the search operation 
$result_search = $domain->search(array('query' => 'abhishekolder'));   
$hitCount = $result_search->getPath('hits/found'); //hits/hit for the document that is found
//print 



//add a suggester
$result_suggester = $client->defineSuggester(array(
    // DomainName is required
    'DomainName' => 'people',
    // Suggester is required
    'Suggester' => array(
        // SuggesterName is required
        'SuggesterName' => 'mysuggester',
        // DocumentSuggesterOptions is required
        'DocumentSuggesterOptions' => array(
            // SourceField is required
            'SourceField' => 'name',
            'FuzzyMatching' => 'low',
            'SortExpression' => 'user_id',
        ),
    ),
));

//indexing after creating suggester
$result_indexing = $client->indexDocuments(array(
    // DomainName is required
    'DomainName' => 'string',
));

//retrieve suggestion from suggester 

?>
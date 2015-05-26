<?php

require 'vendor/autoload.php';

use Aws\Common\Aws;


use Aws\CloudSearch\CloudSearchClient;
use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('**********************', '*************************');

$client = CloudSearchClient::factory(array(
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));

//create a new search domain
$result_createDomain = $client->createDomain(array(
    // DomainName is required
    'DomainName' => 'people2',
));




//json to be  passed to updateServiceAccessPolicies
//*check about escaping all double quotes within the string
//check the version '2013-01-01'
$policy_json='{
  "Version": "2012-10-17",
  "Statement": [
    {      
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

/*
{
  "Version": "2012-10-17",
  "Statement": [
    {
      "Effect": "Allow",
      "Principal": {
        "AWS": [
          "*"
        ]
      },
      "Action": [
        "cloudsearch:*"
      ]
    }
  ]
}
*/
//configure access policy
$result_access = $client->updateServiceAccessPolicies(array(
    // DomainName is required
    'DomainName' => 'people2',
    // AccessPolicies is required
    'AccessPolicies' => $policy_json, 
));


//configure scaling option
$result_scaling = $client->updateScalingParameters(array(
    // DomainName is required
    'DomainName' => 'people2',
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
    'DomainName' => 'people2',
    // MultiAZ is required
    'MultiAZ' => true,
));


//domain information
$result_domainInfo = $client->describeDomains(array(
    'DomainNames' => array('people2'),
));



// //prepare data to be uploaded for cloudsearch 

//configure the index fields
$result_nameIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people2',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'name',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            // 'SourceField' => 'name',  
            'ReturnEnabled' => true,
            'SortEnabled' => true,
            'HighlightEnabled' => true, 
            // 'AnalysisScheme' => 'English',
        ),        
    ),    
));

$result_emailIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people2',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'email',
        // IndexFieldType is required
        'IndexFieldType' => 'text',
        'TextOptions' => array(            
            // 'SourceField' => 'email',  
            'ReturnEnabled' => true,
            'SortEnabled' => true,
            'HighlightEnabled' => true,
            // 'AnalysisScheme' => 'English',
        ),        
    ), 
));


$result_telephoneIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people2',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'telephone',
        // IndexFieldType is required
        'IndexFieldType' => 'int',
        'IntOptions' => array(            
            // 'SourceField' => 'telephone',
            'FacetEnabled' => true,
            'SearchEnabled' => true,
            'ReturnEnabled' => true,
            'SortEnabled' => true,
        ),        
    ), 
));

$result_userIdIndexField = $client->defineIndexField(array(
    // DomainName is required
    'DomainName' => 'people2',
    // IndexField is required
    'IndexField' => array(
        // IndexFieldName is required
        'IndexFieldName' => 'user_id',
        // IndexFieldType is required
        'IndexFieldType' => 'int',
        'IntOptions' => array(            
            // 'SourceField' => 'user_id', //The name of the source field to map to the field.
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
    'DomainName' => 'people2',
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
    'DomainName' => 'people2',
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
    'DomainName' => 'people2',
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
    'DomainName' => 'people2',
));


//add a suggester
$result_suggester = $client->defineSuggester(array(
    // DomainName is required
    'DomainName' => 'people2',
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
//it returns state param : which tells RequiresIndexDocuments

//indexing after creating suggester
$result_indexing = $client->indexDocuments(array(
    // DomainName is required
    'DomainName' => 'people2',
));


//retrieve suggestions by sending requests to the "suggest" resource on a domain's search endpoint via HTTP GET

//http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2012-10-17/suggest?q=
// Get cURL resource
//use curl for get /post http://codular.com/curl-with-php
$curl = curl_init();
// // Set some options - we are passing in a useragent too here
$url="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/suggest?q=abhishek&suggester=mysuggester";
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url,    
));
// // Send the request & save response to $resp
$result_curlSuggest = curl_exec($curl);
// // Close request to clear up some resources
curl_close($curl);
print_r($result_curlSuggest);


?>

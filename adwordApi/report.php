<?php

/*
To have the functions and classes available to your applications include
the services class you want to use.

For example if you want to use Google AdGroup Service you need to include
AdWordAdGroupService.inc file.
*/

// Set the include path and the require the folowing PHP file.


$path = dirname(__FILE__) . '/lib';		//To get the directory of current included file: (Returns parent directory's path)
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require_once dirname(__FILE__) . '/lib/Google/Api/Ads/AdWords/Lib/AdWordsUser.php';	//require is identical to include except upon failure it will also produce a fatal E_COMPILE_ERROR level error
require_once dirname(__FILE__) . '/lib/Google/Api/Ads/AdWords/Util/ReportUtils.php';



// Create an AdWordsUser instance using the default constructor, which will load
// information from the auth.ini file as described above.

define("API_VERSION", "v201502");
 
$user = new AdWordsUser();
// $user->SetClientCustomerId("623-561-9930");
// $user->SetDeveloperToken(DEVELOPER_TOKEN);
$user->SetClientCustomerId("623-561-9930");




//report generation




//use from example download criteria report!
// Load the service, so that the required classes are available.
$user->LoadService('ReportDefinitionService', API_VERSION);


// Create selector.
$selector = new Selector();
$selector->fields = array('CampaignId', 'AdGroupId', 'Id', 'Criteria',						//chenage query as per 
      'CriteriaType', 'Impressions', 'Clicks', 'Cost');

// Optional: use predicate to filter out paused criteria.
$selector->predicates[] = new Predicate('Status', 'NOT_IN', array('PAUSED'));


// Create report definition.
$reportDefinition = new ReportDefinition();
$reportDefinition->selector = $selector;
$reportDefinition->reportName = 'Criteria performance report #' . uniqid();
$reportDefinition->dateRangeType = 'LAST_7_DAYS';
$reportDefinition->reportType = 'CRITERIA_PERFORMANCE_REPORT';
$reportDefinition->downloadFormat = 'CSV';


// Set additional options.
$options = array('version' => API_VERSION);

$filePath='report.CSV';
// Download report.
ReportUtils::DownloadReport($reportDefinition, $filePath, $user, $options);

printf("Report with name '%s' was downloaded to '%s'.\n",
     $reportDefinition->reportName, $filePath);

echo "<br/>";





?>
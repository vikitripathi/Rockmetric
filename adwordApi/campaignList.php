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

//echo get_include_path();   //include_path contains a semicolon (;) separated list of include paths.


//echo dirname(__FILE__);		//C:\wamp\www\googleAdwords  , it prints the current files directory!

//implode

// Create an AdWordsUser instance using the default constructor, which will load
// information from the auth.ini file as described above.

define("API_VERSION", "v201502");
 
$user = new AdWordsUser();
// $user->SetClientCustomerId("623-561-9930");
// $user->SetDeveloperToken(DEVELOPER_TOKEN);
$user->SetClientCustomerId("623-561-9930");



echo "<br/>";

echo "<br/>";


// // Get a list of campaigns
$campaignService = $user->GetService('CampaignService', API_VERSION);

// Create selector.
$selector = new Selector();
$selector->fields = array('Id', 'Name' ,'Status');
$selector->ordering[] = new OrderBy('Name', 'ASCENDING');
// Make the get request.
$page = $campaignService->get($selector);
// // Display results.
if (isset($page->entries)) {
      foreach ($page->entries as $campaign) {
        printf("Campaign with name '%s' and ID '%s'  and status '%s' was found.\n",
            $campaign->name, $campaign->id ,$campaign->status);
      }
} else {
      print "No campaigns were found.\n";
}




echo "<br/>";
echo "====================";
echo "<br/>";





?>
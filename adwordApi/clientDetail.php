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


define("API_VERSION", "v201502");
 
$user = new AdWordsUser();
// $user->SetClientCustomerId("623-561-9930");
// $user->SetDeveloperToken(DEVELOPER_TOKEN);
$user->SetClientCustomerId("623-561-9930");
echo "The details of the client => ";
echo "<br/>";
print_r($user); 



echo "====================";


?>
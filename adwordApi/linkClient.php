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

define("API_VERSION", "v201502");
 
$user = new AdWordsUser();

//$user->SetClientCustomerId("623-561-9930");     //client id 
$user->SetClientCustomerId("401-273-6710");			//test mcc manager id -> for administrative purpose !!
$managedCustomerService =
    $user->GetService('ManagedCustomerService', API_VERSION);

//The ManagedCustomerLink is useful for linking two pre-existing accounts together

$link = new ManagedCustomerLink();
$link->clientCustomerId = 5445751955;//CLIENT_CID;
$link->pendingDescriptiveName = "";
$link->linkStatus = 'PENDING';
$link->managerCustomerId = 4012736710;//MANAGER_CID;


// Create operation.
$operation2 = new LinkOperation();

$operation2->operand = $link;
$operation2->operator = 'ADD';
$operations = array( $operation2);
print_r($operations);
// ADD + PENDING: manager extends invitations
// Make the mutate request.
// echo "<br/>";
// echo "====================";
// $result = $managedCustomerService->mutateLink($operations);
// print_r($result);
echo "<br/>";
echo "====================";
echo "<br/>";
?>
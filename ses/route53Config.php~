<?php
session_start();
require 'vendor/autoload.php';

use Aws\Common\Aws;


//use Aws\Ses\SesClient;
use Aws\Route53\Route53Client;
use Aws\Common\Credentials\Credentials;

$credentials = new Credentials('*****************', '***************************');



//create DNS CNAME record using AWS Route 53
$clientRoute53 = Route53Client::factory(array(
    'credentials' => $credentials,
    'region'  => 'us-west-2'
));

//get hosted  zone ID 
$HostedZoneId='';
$result_listHostedzones = $clientRoute53->listHostedZones();//check id for name=rockmetric.com
print_r($result_listHostedzones['HostedZones']);
echo " <br> <br>";
foreach ($result_listHostedzones['HostedZones'] as  $zone) {
    if (strcmp($zone['Name'], 'rockmetric.com')) {
        $HostedZoneId=$zone['Id'];
        # code...
    };
}
$HostedZoneId=split('/', $HostedZoneId)[2];
print_r($HostedZoneId);

$result_setupDKIM = $clientRoute53->changeResourceRecordSets(array(
    // HostedZoneId is required
    'HostedZoneId' => $HostedZoneId,//for rockmetric.com
    // ChangeBatch is required
    'ChangeBatch' => array(
        // 'Comment' => 'setting DKIM for SES',
        // Changes is required
        'Changes' => array(
            array(
                // Action is required
                'Action' => 'CREATE',//CREATE | DELETE | UPSERT
                // ResourceRecordSet is required
                'ResourceRecordSet' => array(
                    // Name is required
                    'Name' =>$_SESSION["name1"],//get from other function
                    // Type is required
                    'Type' => 'CNAME',
                    // 'SetIdentifier' => 'string',
                    // 'Weight' => integer,
                    // 'Region' => 'string',
                    // 'GeoLocation' => array(
                    //     'ContinentCode' => 'string',
                    //     'CountryCode' => 'string',
                    //     'SubdivisionCode' => 'string',
                    // ),
                    // 'Failover' => 'string',
                    // 'TTL' => integer,
                    'ResourceRecords' => array(
                        array(
                            // Value is required
                            'Value' =>$_SESSION["value1"],//get from other function
                        ),
                        // ... repeated
                    ),
                    // 'AliasTarget' => array(
                    //     // HostedZoneId is required
                    //     'HostedZoneId' => 'string',
                    //     // DNSName is required
                    //     'DNSName' => 'string',
                    //     // EvaluateTargetHealth is required
                    //     'EvaluateTargetHealth' => true || false,
                    // ),
                    // 'HealthCheckId' => 'string',
                ),
            ),
            
            array(
                // Action is required
                'Action' => 'CREATE',//CREATE | DELETE | UPSERT
                // ResourceRecordSet is required
                'ResourceRecordSet' => array(
                    // Name is required
                    'Name' =>$_SESSION["name2"],//get from other function
                    // Type is required
                    'Type' => 'CNAME',
                    // 'SetIdentifier' => 'string',
                    // 'Weight' => integer,
                    // 'Region' => 'string',
                    // 'GeoLocation' => array(
                    //     'ContinentCode' => 'string',
                    //     'CountryCode' => 'string',
                    //     'SubdivisionCode' => 'string',
                    // ),
                    // 'Failover' => 'string',
                    // 'TTL' => integer,
                    'ResourceRecords' => array(
                        array(
                            // Value is required
                            'Value' =>$_SESSION["value2"],//get from other function
                        ),
                        // ... repeated
                    ),
                    // 'AliasTarget' => array(
                    //     // HostedZoneId is required
                    //     'HostedZoneId' => 'string',
                    //     // DNSName is required
                    //     'DNSName' => 'string',
                    //     // EvaluateTargetHealth is required
                    //     'EvaluateTargetHealth' => true || false,
                    // ),
                    // 'HealthCheckId' => 'string',
                ),
            ),

            array(
                // Action is required
                'Action' => 'CREATE',//CREATE | DELETE | UPSERT
                // ResourceRecordSet is required
                'ResourceRecordSet' => array(
                    // Name is required
                    'Name' => $_SESSION["name3"],//get from other function
                    // Type is required
                    'Type' => 'CNAME',
                    // 'SetIdentifier' => 'string',
                    // 'Weight' => integer,
                    // 'Region' => 'string',
                    // 'GeoLocation' => array(
                    //     'ContinentCode' => 'string',
                    //     'CountryCode' => 'string',
                    //     'SubdivisionCode' => 'string',
                    // ),
                    // 'Failover' => 'string',
                    // 'TTL' => integer,
                    'ResourceRecords' => array(
                        array(
                            // Value is required
                            'Value' =>$_SESSION["value3"],//get from other function
                        ),
                        // ... repeated
                    ),
                    // 'AliasTarget' => array(
                    //     // HostedZoneId is required
                    //     'HostedZoneId' => 'string',
                    //     // DNSName is required
                    //     'DNSName' => 'string',
                    //     // EvaluateTargetHealth is required
                    //     'EvaluateTargetHealth' => true || false,
                    // ),
                    // 'HealthCheckId' => 'string',
                ),
            ),

            // ... repeated
        ),
    ),
));

print_r($result_setupDKIM);
echo " <br> <br> ______________________________________________________________________ <br>";






?>

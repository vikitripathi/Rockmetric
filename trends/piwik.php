<?php
//a demo url and data from piwik site

/*
 * The Referrers API lets you access reports about Websites, Search engines, Keywords, Campaigns used to access your website.
 * "getKeywords" returns all search engine keywords
 * "getWebsites" returns referrer websites (along with the full Referrer URL if the parameter &expanded=1 is set)
 *
 *  VisitTime API lets you access reports by Hour (Server time), and by Hour Local Time of your visitors.
 *	
*/
//$url="http://demo.piwik.org/?module=API&method=Referrers.getKeywords&idSite=3&date=yesterday&period=day&format=json&filter_limit=10";
$url="http://tracking.rockmetric.com/?module=API&method=VisitTime.getByDayOfWeek&idSite=1&period=week&date=2015-05-21&format=JSON&token_auth=8e0bbdf0146f1a7af60395405eb1523c";
// echo "The url to fetch data from Piwik <br/>".
// 	 "==> ".$url." <br/> ";

/* gets the data from a URL */
function get_data($url) {
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

//or get data via file_get_contents()  
//If you're opening a URI with special characters, such as spaces, you need to encode the URI with urlencode().

$returned_content = get_data($url);
$siteData=json_decode($returned_content,true);
//var_dump($siteData);
//print_r($siteData);
//echo "<br/>";

//echo $siteData[0]['nb_uniq_visitors'];

// foreach ($siteData as $data) {
// 	# code...
// 	echo $data['nb_actions']." <br/>";
// }
// echo "<br/>";
// print_r($returned_content);
// foreach ($siteData as $data) {
// 	# code...
// 	echo $data['nb_uniq_visitors']." <br/>";
// }
// echo $returned_content->label;


$json="";
$json .='{"cols":[
			{"id":"","label":"Day","pattern":"","type":"string"},
			{"id":"","label":"Total Visits","pattern":"","type":"number"},
			{"id":"","label":"Unique Visitors","pattern":"","type":"number"},
			{"id":"","label":"Total Actions","pattern":"","type":"number"},
			{"id":"","label":"Users","pattern":"","type":"number"},
			{"id":"","label":"Bounce Count","pattern":"","type":"number"}			
			],
		"rows":[';

foreach ($siteData as $data) {
	# code...
	$json .='{"c":
				[
				{"v":"'.$data['label'].'","f":null},
				{"v":'.$data['nb_visits'].',"f":null},
				{"v":'.$data['nb_uniq_visitors'].',"f":null},
				{"v":'.$data['nb_actions'].',"f":null},
				{"v":'.$data['nb_users'].',"f":null},
				{"v":'.$data['bounce_count'].',"f":null}				
				]
			},';
}

$json =substr($json, 0,strlen($json)-1);
//trim

$json .=']
		}';
echo $json;




/*
{"cols":[{"label":"travel_time_date","type":"datetime"},
{"label":"travel_time_duration","type":"number"}],
"rows":[{"c":
[{"v":"travel_time_date(2014, 2, 1, 1, 30, 30)"},{"v":55}]},{"c": 
[{"v":"travel_time_date(2014, 2, 1, 2, 30, 30)"},{"v":80}]},{"c":
[{"v":"travel_time_date(2014, 2, 1, 3, 30, 30)"},{"v":60}]},{"c":
[{"v":"travel_time_date(2014, 2, 1, 4, 30, 30)"},{"v":120}]}]}
*/

?>

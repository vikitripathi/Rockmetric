<?php
// session_start();



$curl = curl_init();

//$term = "dutt"; 
$term = strip_tags(substr($_POST['searchit'],0, 100));    //Strip HTML and PHP tags from  the string we get from the search bar

//send http request to domain search endpoint

//check for more options
// sort=_score desc sorting is by default
$data=array(		
		'q.parser'=>'structured',
		'q.options'=> '{"fields":["name^5","email^2"]}',
		'return'=>'_all_fields'
	);

$urlEncoded=http_build_query($data);
$url="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/search?q=(prefix+field%3Dname+'".$term."')&".$urlEncoded;


// print_r($url);
// echo "<br/>";

//do we need to url encode(for special characters as white spaces, = etc) the query while sending to HTTP request
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url,    
));
$result_curlSuggest = curl_exec($curl);
curl_close($curl);

// print_r($result_curlSuggest);
// echo "<br/>";

$data=json_decode($result_curlSuggest);
// print_r($data->hits->hit[2]->fields->name);
//echo "<br/>";


$sendData=array();
$count=0;
foreach ($data->{'hits'}->{'hit'} as $var) {
	$sendData[$count]=$data->{'hits'}->{'hit'}[$count]->fields->name;		//get name as we have used name in the query string of the url
	$count++;
	# code...
}




$url2="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/search?q=(prefix+field%3Demail+'".$term."')&".$urlEncoded;

$curl2=curl_init();
curl_setopt_array($curl2, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url2,    
));
$result_curlSuggest2 = curl_exec($curl2);
curl_close($curl2);
//echo "<br/>";
// print_r($result_curlSuggest2);

$data2=json_decode($result_curlSuggest2);


$sendData2=array();
$count2=0;
foreach ($data2->{'hits'}->{'hit'} as $var) {
	$sendData2[$count2]=$data2->{'hits'}->{'hit'}[$count2]->fields->email;	////get email as we have used email in the query string of the url
	$count2++;
	# code...
}



//clubbing the search result of the two url/query strings

if($term=="")
	echo "Enter Something to search";
else{
	
	$str_2 = '';
	$str = '';

	if(($count2-1) >= 0 || ($count-1) >= 0)
	{

		for ($i=0; $i <$count ; $i++) { 
			# code...
			for ($j=0; $j < $count2; $j++) { 
				# code...
				if (strcmp($data->{'hits'}->{'hit'}[$i]->id,$data2->{'hits'}->{'hit'}[$j]->id)==0) {
							# code...
							// print_r($data->{'suggest'}->{'suggestions'}[$i]->id." ----- ".$data_2->{'suggest'}->{'suggestions'}[$j]->id);
							// echo "<br/>";
							$sendData2[$j]='';		//to prevent duplicacy of the data(Profile) as whole
						}		
			}
		}


		if (($count2-1) >= 0){
			for ($i=($count2-1); $i >=0 ; $i--) { 
				if(strcmp($sendData2[$i],'') != 0){
					$str_2 .= $sendData2[$i]."----".$data2->{'hits'}->{'hit'}[$i]->fields->name."---".$data2->{'hits'}->{'hit'}[$i]->fields->telephone."----".$data2->{'hits'}->{'hit'}[$i]->fields->user_id."<br/>\n";
				}
				
			}		
			//$str =substr($str, 0,strlen($str)-1);
			//$str .="}";
		}

		if (($count-1) >= 0)
		{
			for ($i=($count-1); $i >=0 ; $i--) { 
				if(strcmp($sendData[$i],'') != 0){
					$str .= $data->{'hits'}->{'hit'}[$i]->fields->email."-----".$sendData[$i]."----".$data->{'hits'}->{'hit'}[$i]->fields->telephone."-----".$data->{'hits'}->{'hit'}[$i]->fields->user_id."<br/>\n";	
				}
				
			}		
			//$str =substr($str, 0,strlen($str)-1);
			//$str .="}";
		}
	}
	else{
		$str = "No matches found!";
	}
	$str .= $str_2;
	echo $str;
}




?>



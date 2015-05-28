<?php
// session_start();

//retrieve suggestions by sending requests to the "suggest" resource on a domain's search endpoint via HTTP GET
//http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2012-10-17/suggest?q=

$curl = curl_init();
//$term = "abhishekd"; 
$term = strip_tags(substr($_POST['searchit'],0, 100));    //Strip HTML and PHP tags from a string  


/*
or you can use suggest( array $args = array() ) of the cloudesearchdomainCLient
*/
$url="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/suggest?q=".$term."&suggester=mysuggester";//******can we add two suggesters ? like that of email
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url,    
));
$result_curlSuggest = curl_exec($curl);
curl_close($curl);

/*
http://stackoverflow.com/questions/6815520/cannot-use-object-of-type-stdclass-as-array  for json decoding
*/
//print_r($result_curlSuggest);
//echo " <br> <br> ";
$data=json_decode($result_curlSuggest);

$sendData=array();
$count=0;
foreach ($data->{'suggest'}->{'suggestions'} as $var) {
	$sendData[$count]=$data->{'suggest'}->{'suggestions'}[$count]->suggestion;
	$count++;
	# code...
}
//print_r($sendData[2]);
//echo "<br>";
// $var="suggestion_";
// //create session variables
// for ($i=($count-1); $i >=0 ; $i--) { 
// 	# code...
// 	$var .=$i;
// 	$_SESSION[$var]=$sendData[$i];		//storing data in the session variables
// 	$var =substr($var,0,strlen($var)-1);
// }
// $_SESSION["count"]=$count-1;
//print_r($_SESSION["suggestion_1"]);

// echo json_decode($result_curlSuggest)['suggest'];
//use AJAX and SEARCH BAR
//enable cloudwatch!

// $_SESSION[""]=


	// $term = strip_tags(substr($_POST['searchit'],0, 100));
	// $term = mysql_escape_string($term); // Attack Prevention
	// echo $term;
// if($term=="")
// 	echo "Enter Something to search";
// else{
	
// 	$str = '';

// 	if (($count-1) >= 0){
// 		for ($i=($count-1); $i >=0 ; $i--) { 
			
// 			$str .= $sendData[$i]."<br/>\n";
// 		}		
// 		//$str =substr($str, 0,strlen($str)-1);
// 		//$str .="}";
// 	}
// 	else{
// 		$str = "No matches found!";
// 	}

// 	echo $str;
// }

/*
When you request suggestions, Amazon CloudSearch finds all of the documents
whose values in the suggester field start with the specified query string. The beginning of the field must match the query string to be considered a match.

If you want to get suggestions from multiple text fields, you define a suggester for each field and submit separate suggestion requests to get matches from each suggester. 
*/




//$term = strip_tags(substr($_POST['searchit'],0, 100));    //Strip HTML and PHP tags from a string  
$curl_2 = curl_init();
$url_2="http://search-people2-tbng4nu3ryx65trmjjvkeejsai.us-west-2.cloudsearch.amazonaws.com/2013-01-01/suggest?q=".$term."&suggester=mysuggester2";//******can we add two suggesters ? like that of email
curl_setopt_array($curl_2, array(
    CURLOPT_RETURNTRANSFER => 1,//to return as string
    CURLOPT_URL => $url_2,    
));
$result_curlSuggest_2 = curl_exec($curl_2);
curl_close($curl_2);

/*
http://stackoverflow.com/questions/6815520/cannot-use-object-of-type-stdclass-as-array  for json decoding
*/


// print_r($result_curlSuggest);
// echo "<br/>";
// print_r($result_curlSuggest_2);
// echo " <br> <br> ";


$data_2=json_decode($result_curlSuggest_2);

$sendData_2=array();
$count_2=0;
foreach ($data_2->{'suggest'}->{'suggestions'} as $var) {
	$sendData_2[$count_2]=$data_2->{'suggest'}->{'suggestions'}[$count_2]->suggestion;
	$count_2++;
	# code...
}
//print_r($sendData[2]);
//echo "<br>";
// $var="suggestion_";
// //create session variables
// for ($i=($count-1); $i >=0 ; $i--) { 
// 	# code...
// 	$var .=$i;
// 	$_SESSION[$var]=$sendData[$i];		//storing data in the session variables
// 	$var =substr($var,0,strlen($var)-1);
// }
// $_SESSION["count"]=$count-1;
//print_r($_SESSION["suggestion_1"]);

// echo json_decode($result_curlSuggest)['suggest'];
//use AJAX and SEARCH BAR
//enable cloudwatch!

// $_SESSION[""]=


	// $term = strip_tags(substr($_POST['searchit'],0, 100));
	// $term = mysql_escape_string($term); // Attack Prevention
	// echo $term;
if($term=="")
	echo "Enter Something to search";
else{
	
	$str_2 = '';
	$str = '';

	if(($count_2-1) >= 0 || ($count-1) >= 0)
	{

		for ($i=0; $i <$count ; $i++) { 
			# code...
			for ($j=0; $j < $count_2; $j++) { 
				# code...
				if (strcmp($data->{'suggest'}->{'suggestions'}[$i]->id,$data_2->{'suggest'}->{'suggestions'}[$j]->id)==0) {
							# code...
							// print_r($data->{'suggest'}->{'suggestions'}[$i]->id." ----- ".$data_2->{'suggest'}->{'suggestions'}[$j]->id);
							// echo "<br/>";
							$sendData_2[$j]='';
						}		
			}
		}


		if (($count_2-1) >= 0){
			for ($i=($count_2-1); $i >=0 ; $i--) { 
				if(strcmp($sendData_2[$i],'') != 0){
					$str_2 .= $sendData_2[$i]."<br/>\n";
				}
				
			}		
			//$str =substr($str, 0,strlen($str)-1);
			//$str .="}";
		}

		if (($count-1) >= 0)
		{
			for ($i=($count-1); $i >=0 ; $i--) { 
				if(strcmp($sendData[$i],'') != 0){
					$str .= $sendData[$i]."<br/>\n";	
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



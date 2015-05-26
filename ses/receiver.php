<?php
//The endpoint to receive the notifications

// read JSon input

//Get the raw post data from the request. This is the best-practice method as it does not rely on special php.ini directives
//like $HTTP_RAW_POST_DATA. Amazon SNS sends a JSON object as part of the raw post body.
$postData = file_get_contents("php://input");
//echo $postData;
//$file = fopen("subscribe.txt","w");
$txt="";
$file = 'subscribe.txt';
file_put_contents($file, $postData);//append parameter
$data_back = json_decode($postData);
//var_dump($data_back);
//$data_back=$postData;


/*
After you subscribe an HTTP/HTTPS endpoint, Amazon SNS sends a subscription confirmation message to the HTTP/HTTPS endpoint.
This message contains a SubscribeURL value that you must visit to confirm the subscription (alternatively, you can use the Token value
with the ConfirmSubscription)
*/
//The subscription confirmation message is a POST message with a message body that contains a JSON document with the following name/value pairs.

//can use confirmsubscription of sns api 
if($data_back->Type == "SubscriptionConfirmation")
{

$url=$data_back->SubscribeURL;//as std type

//$xml = file_get_contents($url);//to send get request for subscription over http
$curl_handle=curl_init();//initialize a cURL session
curl_setopt($curl_handle,CURLOPT_URL,$url);
curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
curl_exec($curl_handle);//execeute the session
curl_close($curl_handle);


//echo $url;

}
// print_r($data_back);

// if($data_back->Message->notificationType == "Delivery"){
// 		//Do what you want with the data here.
// 		//fwrite($fh, $json->Subject);
// 		//fwrite($fh, $json->Message);
//     	//echo $data_back->mail->messageId . " <br/>  ";
// 		//echo $data_back->delivery->timestamp . "<br/>";
// 		$txt .=$data_back->Message->messageId." , ";
// 		$txt .=$data_back->Message->delivery->timestamp." , ";
// 		file_put_contents($file, $txt);
// 		//fwrite($file,$txt); //use file_put_contents in final stage
// 		//fclose($file);

// 	}

if($data_back->Type == "Notification"){ 
		//Read the values for Subject and Message to get the
		// notification information that was published to the topic
		//this to receive a publish  message from a topic!
		$newData=json_decode($data_back->Message);
		$txt .=$newData->notificationType." , ";
		$txt .=$newData->mail->source." , ";
		$txt .=$newData->mail->timestamp." , ";
		file_put_contents($file, $txt,FILE_APPEND);
		//Do what you want with the data here.
		//fwrite($fh, $json->Subject);
		//fwrite($fh, $json->Message);
		// echo $data_back->MessageId . " <br/>  ";
		// echo $data_back->Subject . " <br/> ";
		// echo $data_back->Message . " <br/> ";
		// echo $data_back->Timestamp . "<br/>";

	}

?>	
<?php
$access_token = 'phaEYrdmtLGy30cBJkK2zB9eke3JLwcgU0KSMRuII1f/c/2Ml8NxvxdXY0Z7BElsVR3CJOvbGeebyiBFtiFnzML4e14AA+aN88GeTdYCnLvjRLMrY+oWP5FoPyjeHSKau+s1NNv7gRRYQGzVFwwx2AdB04t89/1O/w1cDnyilFU=';
$me = 'bank';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		
		// === Sniff image send in group === //
		if ($event['type'] == 'message' && $event['message']['type'] == 'image') {
			if ($event['source']['type'] == "group")    
				{
				    $dumpObj = print_r($event,true);
				    error_log("===== DUMP IMAGE =====");
				    error_log("$dumpObj");
				    error_log("======================");
				    error_log("Sniff GID : {$event['source']['groupId']} \t Text : {$event['message']['text']}");
				}
				else if ($event['source']['type'] == "room") 
				{
				    $dumpObj = print_r($event,true);
				    error_log("===== DUMP IMAGE =====");
				    error_log("$dumpObj");
				    error_log("======================");
				    error_log("Sniff GID : {$event['source']['roomId']} \t Text : {$event['message']['text']}");
				}
		}
		
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			
			if ($event['message']['text'] == 'stock') {
			// Get replyToken
			$replyToken = $event['replyToken'];
		
			$msg1 = [
				'type' => 'message',
				'label' => 'Buy',
				'text' => 'Yes',
			];
				
			
			$msg2 = [
				'type' => 'message',
				'label' => 'Sell',
				'text' => 'No',
			];
				
			$act = [
  				[$msg1],
				[$msg2],
  				];
				
			$template = [
				'type' => 'buttons',
				//'thumbnailImageUrl' => 'https://dry-dawn-14913.herokuapp.com/screen.jpg',
				'title' => 'Menu',
				'text' => 'Please select',
				'actions' => [$act],
				
			];
			// Build message to reply back
			$messages = [
				'type' => 'template',
				'altText' => 'Which factor that you interest',
				'template' => [$template],
			];
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			$me = $result;
			curl_close($ch);
			echo $result . "\r\n";
			} else {
			
			// Get text sent
			//$text = $event['source']['userId'];
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text
			];
				
				if ($event['source']['type'] == "group")    
				{
				    $dumpObj = print_r($event,true);
				    error_log("===== DUMP =====");
				    error_log("$dumpObj");
				    error_log("================");
				    error_log("Sniff GID : {$event['source']['groupId']} \t Text : {$event['message']['text']}");
				}
				else if ($event['source']['type'] == "room") 
				{
				    $dumpObj = print_r($event,true);
				    error_log("===== DUMP =====");
				    error_log("$dumpObj");
				    error_log("================");
				    error_log("Sniff GID : {$event['source']['roomId']} \t Text : {$event['message']['text']}");
				}
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			/* // SILENT MODE
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			*/
			echo $result . "\r\n";
			}
		}
		else if ($event['type'] == 'join') {
			error_log("JOIN Event type : {$event['source']['type']}");
			error_log("GroupId : {$event['source']['groupId']}");
		}
	}
}

echo "OK";	

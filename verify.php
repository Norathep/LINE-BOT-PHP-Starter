<?php
$access_token = 'phaEYrdmtLGy30cBJkK2zB9eke3JLwcgU0KSMRuII1f/c/2Ml8NxvxdXY0Z7BElsVR3CJOvbGeebyiBFtiFnzML4e14AA+aN88GeTdYCnLvjRLMrY+oWP5FoPyjeHSKau+s1NNv7gRRYQGzVFwwx2AdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
<?php
	$token = file_get_contents(__DIR__."/token.txt");
	$project_id = file_get_contents(__DIR__."/token.txt");

	$content = base64_encode(file_get_contents(__DIR__."/102-3.png"));

	$json_body = [
		"requests" => [
			[
				"image" => [
					"content" => $content
				],
				"features" => [
					"type" => "TEXT_DETECTION"
				]
			]
		]
	];

	$ch = curl_init('https://vision.googleapis.com/v1/images:annotate');
	curl_setopt($ch, CURLOPT_HTTPHEADER, [
		'Content-Type:application/json; charset=utf-8',
		"Authorization: Bearer $token",
		"X-Goog-User-Project: $project_id"
	]);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($json_body, JSON_UNESCAPED_UNICODE)); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
	 
	$res = json_encode($res, JSON_UNESCAPED_UNICODE);

	if (!file_exists(__DIR__."/response.json"));
		touch(__DIR__."/response.json");

	file_put_contents(__DIR__."/response.json", $res);
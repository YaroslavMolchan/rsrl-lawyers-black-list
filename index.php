<?php
ob_start();
require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$usernames = [
	'Chef',
	'Verg',
	'm.a.l.o.y',
	'Par0v0z',
	'p4RO',
	'depositko_O',
	'Chet_Smith',
	'odb',
	'[GOLDBERG]',
	'Chip_Foose',
	'Remyan',
	'EagleEye',
	'LimeFail',
	'James_LaFleur',
	'Barfly',
	'Chet_Brown',
	'v4ns_',
	'FOREVERYOUNG',
	'TEAMWORK',
	'_hazard_',
	'Alex_Portego',
	'Bws_',
	'ant[i]dot',
	'BigSmitH',
	'...ShotGun...',
	'ХoGaN',
	'Nike_Bailey',
	'John_Ringo',
	'EGOIST_',
	'vasyan',
	'Hashirama',
	'Andrey_Kove',
	'MonsTa',
	'rondeLL',
	'Domenikano_O',
	'MiN',
	'DeN_',
	'Ex.TezZy'
];

$dom = new Dom;
$dom->loadFromUrl('http://gta.rsrl.ru/server');
$contents = $dom->find('.listplscrn tr');

$result = [
	'all' => count($contents),
	'online' => 0,
	'users' => []
];

$exists_users = [];
$exists_users_links = [];
foreach ($contents as $content)
{
    // do something with the html
    $html = $content->innerHtml;
	$pattern = '/<a\s+(?:[^>]*?\s+)?href="(?:[^"]*)">(.*?)<\/a>/';
	preg_match_all($pattern, $html, $matches);
	$exist_username = strtolower($matches[1][0]);
	$exist_ink = $matches[0][0];
	array_push($exists_users, $exist_username);
	array_push($exists_users_links, $exist_ink);
	// foreach ($usernames as $username) {
	// 	if ($exist_username == strtolower($username)) {
	// 		$result['online']++;
	// 		array_push($result['users'], $exist_ink);
	// 	}
	// }
}
$find_users = array_intersect($exists_users, $usernames);
echo '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>RSRL Lawyers</title>

	<!-- Bootstrap core CSS -->
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="list-group">
				<li class="list-group-item active">
					<span class="badge">'.count($find_users).'</span>
					Игроки из Черного списка в сети:
				</li>
';
foreach ($find_users as $key => $name) {
	// присваивает <body text='black'>
	echo str_replace("href=", "class=\"list-group-item\" target=\"_blank\" href=", $exists_users_links[$key]);
}
echo '</div>
		</div>
	</div>
</body>
</html>';
$output = ob_get_clean();
echo $output;

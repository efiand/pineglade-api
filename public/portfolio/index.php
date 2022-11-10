<?php
$TOKEN = parse_ini_file('../.env')['GH_TOKEN'];
$headers = [
	'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
	'Authorization: Basic '. base64_encode('efiand:' . $TOKEN)
];

function adapt_repos($repo) {
	global $headers;

	$created_at = strtotime($repo['created_at']);
	$languages = [];

	$raw_languages = json_decode(fetch($repo['languages_url'], $headers), true);
	foreach ($raw_languages as $name => $count) {
		if ($count > 1000) {
			$languages[] = $name;
		}
	}

	return [
		'id' => $created_at,
		'date' => date('d.m.Y', $created_at),
		'description' => $repo['description'],
		'homepage' => $repo['homepage'],
		'languages' => $languages,
		'name' => $repo['name'],
		'topics' => $repo['topics'],
		'url' => $repo['html_url'],
		'year' => date('Y', $created_at)
	];
}

$raw_repositories = json_decode(fetch('https://api.github.com/users/efiand/repos?per_page=100', $headers), true);

$repositories = [];
for ($i = 0; $i < count($raw_repositories); $i++) {
	if (array_search('portfolio-project', $raw_repositories[$i]['topics'])) {
		$repositories[] = adapt_repos($raw_repositories[$i]);
	}
}

$data = [
	'bio' => fetch('https://raw.githubusercontent.com/efiand/efiand.github.io/main/docs/about.md', $headers),
	'repositories' => $repositories
];

response($data);

<?php
$domains = file('domains.txt');
$intranets = fopen('intranets.txt', 'w');
$prefixes = array('my', 'portal', 'intranet');
foreach($domains as $domain) {
	$domain = '.'. trim($domain);
	foreach($prefixes as $prefix) {
		$result = dns_get_record($prefix . $domain);
		print $prefix . $domain . "\n";
		if($result && $result[0]['host']) {
			fwrite($intranets, $result[0]['host'] ."\n");
		}
	}
}
fclose($intranets);
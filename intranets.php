<?php
$domains = file('domains.txt');
$intranets = fopen('intranets.txt', 'w');
$prefixes = array('my', 'portal', 'intranet');
foreach($domains as $domain) {
        $domain = '.'. trim($domain);
        foreach($prefixes as $prefix) {
                $result = dns_get_record($prefix . $domain);
                if($result && $result[0]['host']) {
                        $result = file_get_contents('http://'. $result[0]['host']);
                        if($result) {
                                fwrite($intranets, $result[0]['host'] ."\n");
                                print $prefix . $domain ."\n";
                        }
                }
        }
}
fclose($intranets);

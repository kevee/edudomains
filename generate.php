<?php

$alpha = range('a', 'z');
$file = fopen('domains.txt', 'a');
$final = array();
foreach($alpha as $a) {
  foreach($alpha as $b) {
      $output = array();
      exec('whois '. $a . $b. '%.edu', $output);
      $i = 31;
      $count = 0;
      while(isset($output[$i])) {
        $d = strtolower($output[$i]);
        if(strpos($d, '@')) {
          $d = explode('@', $d);
          $d = $d[1];
        }
        if(strpos($d, '.edu') !== false) {
          if(strpos($d, "\t")) {
            $d = reset(explode("\t", $d));
          }
          if(strpos($d, ' ')) {
            $d = reset(explode(" ", $d));
          }
          $d = parse_url('http://'. $d);
          if($d['host']) {
            $final[trim($d['host'])] = trim($d['host']);
          }
          $count++;
        }
        $i++;
      }
    print $a. $b . " " . count($final) . "\n";
  }
}
ksort($final);
foreach($final as $d) {
  if(substr_count($d, '.') == 1) {
    fwrite($file, $d . "\n");
  }
}
fclose($file);
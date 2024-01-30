## Pistes

* List process
```console
~$ ps -aux
flag 11 process lua /home/user/level11/level11.lua
```

* Looking for special group right or user right
```console
~$ id 
uid=2001(level01) gid=2001(level01) groups=2001(level01),100(users)
```

* Looking for hidden files
```console
~$ find / -user flag01 -name ".*" 2>/dev/null
```

* More looking for files
```console
~$ find / -name "flag01" 2>/dev/null
```

* Looking for cap files
```console
~$ find / -name "*.*cap" 2>/dev/null
/usr/share/doc/w3m/ja/README.mailcap
/rofs/usr/share/doc/w3m/ja/README.mailcap
```
```console

```
```console
~$ scp -p 4243 level01@localhost://usr/share/doc/w3m/ja/README.mailcap ./
```
--> useless

## Solution

/etc/shadow --> stores information about user passwords and enforces password policies

/etc/passwd --> stores user account information

* Looking for info about the account flag01
```console
~$ cat /etc/passwd
flag01:42hDRfypTqqnw:3001:3001::/home/flag/flag01:/bin/bas
```

* Password is encrypted, lets crack it
```console
~$ docker build -t john-the-reaper-img .
~$ docker run -it --name john-the-reaper john-the-reaper-img /bin/bash
```

```console
~$ john passwd
~$ john passwd --show
```

```abcdefg```

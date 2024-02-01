## Pistes

We have an executable, so we decompile it using ghidra

```c
char * afterSubstr(char *param_1,int param_2)

{
  bool bVar1;
  int local_10;
  char *local_8;
  
  bVar1 = false;
  for (local_8 = param_1; *local_8 != '\0'; local_8 = local_8 + 1) {
    bVar1 = true;
    for (local_10 = 0; (bVar1 && (*(char *)(local_10 + param_2) != '\0')); local_10 = local_10 + 1)
    {
      if (*(char *)(local_10 + param_2) != local_8[local_10]) {
        bVar1 = false;
      }
    }
    if (bVar1) break;
  }
  if (bVar1) {
    local_8 = local_8 + local_10;
  }
  else {
    local_8 = (char *)0x0;
  }
  return local_8;
}


undefined4 isLib(undefined4 param_1,undefined4 param_2)

{
  bool bVar1;
  char *pcVar2;
  undefined4 uVar3;
  int local_10;
  char *local_8;
  
  pcVar2 = (char *)afterSubstr(param_1,param_2);
  if (pcVar2 == (char *)0x0) {
    uVar3 = 0;
  }
  // parse memory address ex: 08048000-08050000
  else if (*pcVar2 == '-') {
    bVar1 = false;
    //('/' < *local_8 && (*local_8 < ':') --> check if char is 0-9
    while ((local_8 = pcVar2 + 1, '/' < *local_8 && (*local_8 < ':'))) {
      bVar1 = true;
      pcVar2 = local_8;
    }
    if ((bVar1) && (*local_8 == '.')) {
      bVar1 = false;
      for (local_8 = pcVar2 + 2; ('/' < *local_8 && (*local_8 < ':')); local_8 = local_8 + 1) {
        bVar1 = true;
      }
      if (bVar1) {
        for (local_10 = 0; (&DAT_08048c99)[local_10] != '\0'; local_10 = local_10 + 1) {
          if ((&DAT_08048c99)[local_10] != local_8[local_10]) {
            return 0;
          }
        }
        uVar3 = 1;
      }
      else {
        uVar3 = 0;
      }
    }
    else {
      uVar3 = 0;
    }
  }
  else {
    uVar3 = 0;
  }
  return uVar3;
}

size_t main(int argc,int argv)
{
  char cVar1;
  bool bVar2;
  long lVar3;
  size_t ret_fgets;
  char *pcVar5;
  int fd_maps;
  int ret_isLib;
  uint it_decr;
  int in_GS_OFFSET;
  byte byte_zero;
  uint it_incr;
  undefined buffer_fgets [256];
  int local_14;

  byte_zero = 0;
  local_14 = *(int *)(in_GS_OFFSET + 0x14);
  bVar2 = false;
  it_incr = 0xffffffff;

  //Block debugger
  lVar3 = ptrace(PTRACE_TRACEME,0,1,0);
  if (lVar3 < 0) {
    puts("You should not reverse this");
    ret_fgets = 1;
  }

  // if no debugger
  else {

	//get LD_PRELOAD from env --> no
    pcVar5 = getenv("LD_PRELOAD");

	//if LD_PRELOAD is NULL --> no
    if (pcVar5 == (char *)0x0) {
  
		//open ld.so.preload --> no
      fd_maps = open("/etc/ld.so.preload",0);
  
	  //if open("/etc/ld.so.preload",0) FAILURE
      if (fd_maps < 1) {
    
		//open /proc/self/maps --> yes
        fd_maps = syscall_open("/proc/self/maps",0);
  
		// if open /proc/self/maps FAILURE
        if (fd_maps == -1) {
          fwrite("/proc/self/maps is unaccessible, probably a LD_PRELOAD attempt exit..\n",1,0x46,
                 stderr);
          ret_fgets = 1;
        }
  
		// if open /proc/self/maps SUCCESS
        else {
    
          do {
            
            do {
              
              // loop read 256 char until ret_isLib is TRUE
              while( true ) {
                ret_fgets = syscall_gets(buffer_fgets, 256, fd_maps); // read first 256 char of file /proc/self/maps in buffer_fgets
                // si fgets fail -> goto ?
                if (ret_fgets == 0) goto GO_TO_STOP;
                ret_isLib = isLib(buffer_fgets,&DAT_08048c2b);
                if (ret_isLib == 0) break;
                bVar2 = true;
              }
          
            } while (!bVar2);

            ret_isLib = isLib(buffer_fgets,&DAT_08048c30);

            //check argc == 2
            if (ret_isLib != 0) {
              if (argc == 2) goto GO_TO_LOGIC;
              ret_fgets = fwrite("You need to provied only one arg.\n",1,0x22,stderr);
              goto GO_TO_STOP;
            }

            // try to find anonymous memory segment (like stack of heap)
            ret_isLib = afterSubstr(buffer_fgets,"00000000 00:00 0");

            //loop stops when find or do not find "00000000 00:00 0" ??
          } while (ret_isLib != 0);
  
          ret_fgets = fwrite("LD_PRELOAD detected through memory maps exit ..\n",1,0x30,stderr);
        }

      }

      // if open("/etc/ld.so.preload",0) SUCCESS
      else {
        fwrite("Injection Linked lib detected exit..\n",1,0x25,stderr);
        ret_fgets = 1;
      }

    }

    //if LD_PRELOAD (from env) is NOT NULL 
    else {
      fwrite("Injection Linked lib detected exit..\n",1,0x25,stderr);
      ret_fgets = 1;
    }

  }

//int local_14
//int in_GS_OFFSET;

//uint it_decr;
//uint it_incr
//it_incr = 0xffffffff;

//char *str;

//byte byte_zero;
// byte_zero = 0;

//char cVar1;
GO_TO_STOP:
  if (local_14 == *(int *)(in_GS_OFFSET + 0x14)) {
    return ret_fgets;
  }
                    // WARNING: Subroutine does not return
  __stack_chk_fail();

GO_TO_LOGIC:
  //it_incr = 0
  it_incr = it_incr + 1;
  it_decr = 0xffffffff; //U_INT_MAX 
  str = *(char **)(argv + 4);

  //DO WHILE USELESS
  // IT DECREC -= LEN ARGV
  do {
    if (it_decr == 0) break;
    it_decr = it_decr - 1;
    char_buffer = *str;
    //str++
    str = str + (uint)byte_zero * -2 + 1;
  } while (char_buffer != '\0');

  //it_derc = 0xfffffff0
  //~it_derc = 0x0000000f

  //~it_decr - 1 = 0x0000000e
  // ~it_decr - 1 = 15
  //15 <= 0
  if (~it_decr - 1 <= it_incr) 
    goto GOTO_PUT_NEWLINE;

  putchar((int)*(char *)(it_incr + *(int *)(argv + 4)) + it_incr);
  goto GO_TO_LOGIC;

GOTO_PUT_NEWLINE:
  ret_fgets = fputc(10,stdout);
  goto GO_TO_STOP;
}
```

When running with gdb we get

```console
You should not reverse this
```

This is caused by ptrace, it's an anti-debugger function more info [here](https://repository.root-me.org/Reverse%20Engineering/x86/Unix/FR%20-%20SSTIC%2006%20-%20Playing%20with%20ptrace.pdf)

buffer_fgets
```console
level09@SnowCrash:~$ head --bytes 256 /proc/self/maps
08048000-08050000 r-xp 00000000 07:00 18931      /usr/bin/head
08050000-08051000 r--p 00007000 07:00 18931      /usr/bin/head
08051000-08052000 rw-p 00008000 07:00 18931      /usr/bin/head
08052000-08073000 rw-p 00000000 00:00 0          [heap]
```

## Solutions

After a lot of digging we decided to stop trying to reverse engineer the executable and focus to decrypt the token in the file

The executable is reading the token (which contains the password for user flag09) but is applying  
a encryption logic

Logic is for each character in the string, adding the value of the index to the ascii value of the character

```console
level09@SnowCrash:~$ ./level09 aaaa
abcd
```

Lets reverse this encryption!

```console
level09@SnowCrash:~$ cat token < ./level09
f4kmm6p|=�p�n��DB�Du{��
```

The output contains non writable ascii character, and character outside of the ascii table  

```console
level09@SnowCrash:~$ cat token < ./level09 | od -c
0000000   f   4   k   m   m   6   p   |   = 202 177   p 202   n 203 202
0000020   D   B 203   D   u   { 177 214 211  \n
0000032
```

`od -c` => octal dump  
Those non writable characters are represented by a octale value  with od -c



```
`f 4 k m m 6 p | = 202 177 p 202 n 203 202 D B 203 D u { 177 214 211`	// output od -c
`f 4 k m m 6 p | = 130 127 p 130 n 131 130 D B 131 D u { 127 140 137`	// octale to decimal
`f 3 i j i 1 j u 6 121 117 e 118 a 117 115 4 B 113 1 a f 105 117 113`	// offset : -index
`f 3 i j i 1 j u 5   y   u e   v a   u   s 4 1   q 1 a f   i   u   q` 	// asccii to char 

```

Final string is:`f3iji1ju5yuevaus41q1afiuq`

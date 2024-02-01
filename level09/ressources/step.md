### Solutions

We have an executable, so we decompile it using ghidra

```c


size_t main(int param_1,int param_2)
{
  char cVar1;
  bool bVar2;
  long lVar3;
  size_t sVar4;
  char *pcVar5;
  int iVar6;
  int iVar7;
  uint uVar8;
  int in_GS_OFFSET;
  byte bVar9;
  uint local_120;
  undefined local_114 [256];
  int local_14;

  bVar9 = 0;
  local_14 = *(int *)(in_GS_OFFSET + 0x14);
  bVar2 = false;
  local_120 = 0xffffffff;

  //Block debugger
  lVar3 = ptrace(PTRACE_TRACEME,0,1,0);
  if (lVar3 < 0) {
    puts("You should not reverse this");
    sVar4 = 1;
  }
  else {

	//get LD_PRELOAD from env
    pcVar5 = getenv("LD_PRELOAD");
	//if LD_PRELOAD is NULL
    if (pcVar5 == (char *)0x0) {
		//open ld.so.preload
      iVar6 = open("/etc/ld.so.preload",0);
	  //if open fail
      if (iVar6 < 1) {
		//open /proc/self/maps
        iVar6 = syscall_open("/proc/self/maps",0);
		// if open fail
        if (iVar6 == -1) {
          fwrite("/proc/self/maps is unaccessible, probably a LD_PRELOAD attempt exit..\n",1,0x46,
                 stderr);
          sVar4 = 1;
        }
		// if open success
        else {
          do {
            do {
              while( true ) {
                sVar4 = syscall_gets(local_114,0x100,iVar6);
                if (sVar4 == 0) goto LAB_08048a77;
                iVar7 = isLib(local_114,&DAT_08048c2b);
                if (iVar7 == 0) break;
                bVar2 = true;
              }
            } while (!bVar2);
            iVar7 = isLib(local_114,&DAT_08048c30);
            if (iVar7 != 0) {
              if (param_1 == 2) goto LAB_08048996;
              sVar4 = fwrite("You need to provied only one arg.\n",1,0x22,stderr);
              goto LAB_08048a77;
            }
            iVar7 = afterSubstr(local_114,"00000000 00:00 0");
          } while (iVar7 != 0);
          sVar4 = fwrite("LD_PRELOAD detected through memory maps exit ..\n",1,0x30,stderr);
        }
      }
      else {
        fwrite("Injection Linked lib detected exit..\n",1,0x25,stderr);
        sVar4 = 1;
      }
    }
    else {
      fwrite("Injection Linked lib detected exit..\n",1,0x25,stderr);
      sVar4 = 1;
    }
  }
LAB_08048a77:
  if (local_14 == *(int *)(in_GS_OFFSET + 0x14)) {
    return sVar4;
  }
                    // WARNING: Subroutine does not return
  __stack_chk_fail();
LAB_08048996:
  local_120 = local_120 + 1;
  uVar8 = 0xffffffff;
  pcVar5 = *(char **)(param_2 + 4);
  do {
    if (uVar8 == 0) break;
    uVar8 = uVar8 - 1;
    cVar1 = *pcVar5;
    pcVar5 = pcVar5 + (uint)bVar9 * -2 + 1;
  } while (cVar1 != '\0');
  if (~uVar8 - 1 <= local_120) goto code_r0x080489ca;
  putchar((int)*(char *)(local_120 + *(int *)(param_2 + 4)) + local_120);
  goto LAB_08048996;
code_r0x080489ca:
  sVar4 = fputc(10,stdout);
  goto LAB_08048a77;
}
```

When running with gdb we get

```console
You should not reverse this
```

This is caused by ptrace, it's an anti-debugger function more info [here](https://repository.root-me.org/Reverse%20Engineering/x86/Unix/FR%20-%20SSTIC%2006%20-%20Playing%20with%20ptrace.pdf)

## Solution

* Found pcap in user home
```console
~$ ls
level02.pcap
```

* copy the pcap file
```console
scp -P 4243 level02@localhost:/home/user/level02/level02.pcap level02/
```

* open the pcap file in wireshark, found this after "Password:"

```
ft_wandr...NDRel.L0L
```

* what are . ?

. are character outside of the classic ascii table  
They correspond to 7F in data stream  
7f is backspace

* So real password
```
ft_wandr 7f 7f 7f NDRel 7f LOL
```

`ft_waNDReL0L`

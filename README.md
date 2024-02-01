# SnowCrash Project
The SnowCrash project is a series of challenges designed to introduce various aspects of cybersecurity. Throughout these challenges, we will be required to apply different methods to gain a deeper understanding of IT systems.

To access the challenges, you need to load the snowcrash.iso in a VM

## The challenges

Register as user level00 when launching the .iso

Once registered as `levelXX`, you’re gonna have to find the password that will log you in with
the "flagXX" account

Once logged to the `flagXX` account, launch the `getflag` command.
It will give you the password to connect to the next account: `levelXX+1`  
(You may
not be able to connect to a `flagXX` account - in this case, you will
have to find an alternative method, like a command injection on the
program depending on its rights, for instance!).

## The solutions


For each level, the flag required to go to the next `levelXX` account will be in a `flag` file. Any other ressources used to solve the level will be in a `ressources` folder  
A `steps.md` will describe the different step, clue and action taken to overcome the level

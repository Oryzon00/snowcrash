#!/bin/bash

str="f4kmm6p|=M-^B^?pM-^BnM-^CM-^BDBM-^CDu{^?M-^LM-^I$"
echo "test"
for (( i=0; i<${#str}; i++ )); do
    char="${str:$i:1}"
    if [[ $char == '^' ]]; then
        next_char="${str:$((i+1)):1}"
        if [[ $next_char =~ [@-~] ]]; then
            ascii_value=$(( $(printf '%d' "'$next_char") - 64 ))
            echo "ASCII value of $char$next_char is $ascii_value"
        fi
    fi
done

#!/bin/bash
LIST="$(ls *.php)"
for i in $LIST; do
    echo $i
    cat $i | grep include
    echo 
    echo
done

#!/bin/bash

struct=$1
file=$2

cd ../includes/lisp

echo -e "(load \"$file\")" > "$struct.lisp"
 
if [ "$struct" == "beliefs" ]; then
     echo '(load "beliefs_definition")' >> "$struct.lisp"
     echo '(build-belief-list)' >> "$struct.lisp"
     
 elif [ "$struct" == "predictions" ]; then
    echo "(load-all-predictions nil)" >> "$struct.lisp"
fi
    
echo "(json:encode (reverse $struct*))" >> "$struct.lisp"

sbcl --core sbcl.core-with-slime --script "$struct.lisp" 2>/dev/null | sed -e "s/.*loaded//g"

rm "$struct.lisp"
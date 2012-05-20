#!/bin/bash

struct=$1

echo '(load "encode3")' > "$struct.lisp"

if [ "$struct" == "beliefs" ]; then
    echo '(load "beliefs_definition")' >> "$struct.lisp"
    echo '(build-belief-list)' >> "$struct.lisp"
    
elif [ "$struct" == "predictions" ]; then
    echo "(load-all-predictions nil)" >> "$struct.lisp"
fi
    
echo "(json:encode (reverse $struct*))" >> "$struct.lisp"

sbcl --core sbcl.core-with-slime --script "$struct.lisp" | sed -e "s/.*loaded//g"

rm "$struct.lisp"
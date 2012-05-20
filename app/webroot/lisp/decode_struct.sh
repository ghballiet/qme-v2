#!/bin/bash

struct=$1

echo '(load "decode")' > "decode_$struct.lisp"
echo "(decode-json-$struct \"../json/$struct.json\")" >> "decode_$struct.lisp"
echo "(print (reverse decoded-$struct*))" >> "decode_$struct.lisp"
sbcl --core sbcl.core-with-slime --script "decode_$struct.lisp" 2>/dev/null | sed -e "s/.*loaded//g"
rm "decode_$struct.lisp"
echo

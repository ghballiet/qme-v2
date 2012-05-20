#!/bin/bash

sbcl --core sbcl.core-with-slime --script "get_beliefs.lisp" 2> /dev/null | sed -e 's/.*loaded//g'
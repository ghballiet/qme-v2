(mapc 'require
      '(asdf
        asdf-install))

(defmacro load-or-install (package)
  `(handler-case
       (progn
         (asdf:operate 'asdf:load-op ,package))
     (asdf:missing-component ()
       (asdf-install:install ,package))))

(load-or-install :yason)

(sb-ext:save-lisp-and-die "sbcl.core-with-slime")
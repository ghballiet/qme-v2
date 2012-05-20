(load "encode")
(load "beliefs_definition")
(build-belief-list)
(json:encode (reverse beliefs*))
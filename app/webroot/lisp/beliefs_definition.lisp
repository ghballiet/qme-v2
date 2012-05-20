;; define our own struct for relationship between predictions and facts
;; i.e. whether they agree or disagree
(defvar beliefs* nil)
(setq beliefs* nil)

(defstruct belief id prediction fact relation)

;; rebuild the list of beliefs
(defun build-belief-list ()
  (let ((facts (compare-to-facts facts*))
	)
    (loop for pair in (reverse facts) do
	 (create-belief-from-pair pair))))

;; json encoding of beliefs
(defmethod json:encode ((belief belief) &optional (stream *standard-output*))
  (json:with-output (stream)
    (json:with-object ()
      (json:encode-object-element "id" (string (belief-id belief)))
      (json:encode-object-element "prediction" (string (belief-prediction belief)))
      (json:encode-object-element "fact" (string (belief-fact belief)))
      (json:encode-object-element "relation" (string (belief-relation belief))))))

;; build the list of beliefs based on the predictions and facts
(defun create-belief-from-pair (pair)
  (let ((fact (car pair))
	(prediction (cdr pair))
	(id nil)
	(relation nil))
    (setq id (gen-name 'b))
    (cond ((eq (fact-direction fact) (prediction-direction prediction))
	   (setq relation "AGREE"))
	  (t (setq relation "DISAGREE")))
    (push (make-belief :id id :prediction (prediction-id prediction) :fact (fact-id fact) :relation relation) beliefs*)))


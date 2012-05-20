(load "encode")
(load-all-predictions nil)
(loop for p in (reverse predictions*) do
	      (print (list
		      (prediction-id p)
		      (get-quantity-name-by-id (prediction-from p) quantities*)
		      (prediction-direction p)
      		      (get-quantity-name-by-id (prediction-to p) quantities*))))
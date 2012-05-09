<?
class PlacesController extends AppController {
  public $name = 'Place';
  
  public function beforeFilter() {
    $this->layout = 'ajax';
  }
  
  public function create() {
    pr($this->request->data);
  }
}
?>
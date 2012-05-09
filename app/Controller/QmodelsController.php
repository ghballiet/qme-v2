<?
class QmodelsController extends AppController {
  public $name = 'Qmodel';
  
  function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }
  
  function create() {
    
  }
  
  function edit($id = null) {
    
  }
  
  function delete($id = null) {
    
  }
}
?>
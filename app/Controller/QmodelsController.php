<?
class QmodelsController extends AppController {
  public $name = 'Qmodel';
  
  function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }
  
  function create() {
    if($this->request->is('post') &&
      $model = $this->Qmodel->save($this->request->data)) {
      $this->alertSuccess('Success!', sprintf('Successfully created ' . 
        '<strong>%s</strong>.', $model['Qmodel']['name']), true);
      $this->redirect(array('controller'=>'users',
        'action'=>'dashboard'));
    }
  }
  
  function edit($id = null) {
    
  }
  
  function delete($id = null) {
    
  }
}
?>
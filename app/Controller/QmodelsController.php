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
  
  function edit($short_name = null) {
    
  }
  
  function delete($short_name = null) {
    
  }
  
  function view($short_name = null) {
    $model = $this->Qmodel->findByShortName($short_name);
    $this->set('model', $model);
  }
}
?>
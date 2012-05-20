<?
class UsersController extends AppController {
  public $name = 'User';
  
  public function beforeFilter() {
    $this->Auth->allow('login', 'register');
    $this->set('user', $this->Auth->user());
  }
  
  public function login() {
    if($this->Auth->user() != null)
      $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
    if($this->request->is('post')) {
      if($this->Auth->login()) {
        return $this->redirect($this->Auth->redirect());
      } else {
        $this->alertError('An error has occurred.', 'Incorrect username ' .
          'or password.');
      }
    }    
  }
  
  public function logout() {
    $this->redirect($this->Auth->logout());
  }
  
  public function register() {
    if($this->request->is('post')) {
      if($this->User->save($this->request->data)) {
        $this->alertSuccess('Thank you!', 'You have ' .
          'succesfully registered with ACS.', true);
        if($this->Auth->login())
          return $this->redirect(array('controller'=>'users', 'action'=>'dashboard'));
      } else {
        $this->alertError('An error has occurred.',
          'There is something wrong with your submission. Please correct ' .
          'your entries below, and submit again.');
      }
    }    
  }
  
  public function dashboard() {
    $models = $this->User->Qmodel->findAllByUserId($this->Auth->user('id'));
    $public_models = $this->User->Qmodel->find('all', array(
      'conditions'=>array('Qmodel.private'=>0),
      'order'=>array('Qmodel.name')
    ));
    $this->set('models', $models);
    $this->set('public_models', $public_models);
  }
}
?>
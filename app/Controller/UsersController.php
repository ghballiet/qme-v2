<?
class UsersController extends AppController {
  public $name = 'User';
  
  public function beforeFilter() {
    $this->Auth->allow('login', 'register');
  }
  
  public function login() {
    
  }
  
  public function logout() {
    
  }
}
?>
<?
class User extends AppModel {
  public $name = 'User';
  public $hasMany = array('Qmodel');
  
  public $validate = array(
    'email'=>array(
      'required'=>array(
        'rule'=>'notEmpty',
        'message'=>'An email address is required.'
      ),
      'email'=>array(
        'rule'=>'email',
        'message'=>'Please enter a valid email address.'
      ),
      'unique'=>array(
        'rule'=>'isUnique',
        'message'=>'That email address is already in use.'
      ),
      'email_confirm'=>array(
        'rule'=>array('valuesMatch', 'confirm_email'),
        'message'=>'The email addresses you provided do not match.'
      )
    ),
    'password'=>array(
      'required'=>array(
        'rule'=>'notEmpty',
        'message'=>'Please enter a password.'
      ),
      'password_confirm'=>array(
        'rule'=>array('valuesMatch', 'confirm_password'),
        'message'=>'The passwords you provided do not match.'
      )
    )
  );
  
  public function valuesMatch($rules = array(), $compare = null) {
    foreach($rules as $key=>$value) {
      $v1 = $value;
      $v2 = $this->data[$this->name][$compare];
      if($v1 === $v2)
        continue;
      else
        return false;
    }
    return true;
  }
  
  public function beforeSave($options = array()) {
    $this->data['User']['password'] =
      AuthComponent::password($this->data['User']['password']);
    return true;
  }
}
?>
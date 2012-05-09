<?
class Qmodel extends AppModel {
  public $name = 'Qmodel';
  public $belongsTo = 'User';
  
  public $validate = array(
    'short_name' => array(
      'unique'=>array(
        'rule'=>'isUnique',
        'message'=>'That short name is already in use.'
      )
    )
  );
}
?>
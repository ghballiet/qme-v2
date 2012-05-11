<?
class Place extends AppModel {
  public $name = 'Place';
  public $belongsTo = array(
    'Qmodel', 
    'Parent' => array(
      'className' => 'Place',
      'foreign_key' => 'parent_id'
    )
  );
  public $hasMany = array('Entity');
}
?>
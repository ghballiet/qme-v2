<?
class Fact extends AppModel {
  public $name = 'Fact';
  public $belongsTo = array(
    'Qmodel',
    'Source' => array(
      'className' => 'Entity',
      'foreign_key' => 'source_id'
    ),
    'Target' => array(
      'className' => 'Entity', 
      'foreign_key' => 'target_id'
    )
  );
}
?>
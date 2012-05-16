<?
$this->start('css');
echo $this->Html->css('view');
$this->end();

$this->start('scripts');
echo $this->Html->script('d3.v2.min.js');
echo $this->Html->script('view');
echo $this->Html->script('drawing');
$this->end();
?>

<script type="text/javascript">
  var json = {
    places: [],
    entities: [],
    links: []
  };
  
  json.places = [
<?
foreach($places as $place) {
  printf("    { id: %d, name: '%s', x: %d, y: %d, parent: %d, width: %d, height: %d },\n", 
    $place['Place']['id'], $place['Place']['name'],
    $place['Place']['x'], $place['Place']['y'], $place['Place']['parent_id'],
    $place['Place']['width'], $place['Place']['height']);
}
?>
  ];
</script>

<div class="page-header">
  <h1>
    <? echo $model['Qmodel']['name']; ?>
    <small>
      <?
      printf('Created by %s %s', $model['User']['name'], 
        $model['User']['surname']);
      ?>
    </small>
  </h1>
</div>

<div class="row main">
  <!-- left -->
  <div class="span3 left">
    <ul class="nav nav-list well">    
      <li class="nav-header">Places</li>
      <?
      if($places != null) {
        foreach($places as $place) {
          $place_id = $place['Place']['id'];
          $place_name = $place['Place']['name'];
          $parent_id = $place['Parent']['id'];
          $parent_name = $place['Parent']['name'];
          echo '<li class="place">';
          printf('<a href="#" data-type="places" data-id="%s">', 
            $place_id);            
          echo '<span class="type">place</span> ';
          printf('<span class="name">%s</span>', $place_name);
          if($parent_id != null) {
            echo ' in ';
            printf('<span class="location">%s</span>', $parent_name);
          }
          echo '</a>';
          echo '</li>';
        }
      } else {
        echo '<li><div class="alert alert-info">No places have been created.</div></li>';        
      }
      ?>
      <li class="divider"></li>
      <li class="nav-header">Entities</li>
      <?
      if($entities != null) {
        foreach($entities as $entity) {
          $entity_id = $entity['Entity']['id'];
          $entity_name = $entity['Entity']['name'];
          $entity_type = $entity['Entity']['type'];
          $place_id = $entity['Place']['id'];
          $place_name = $entity['Place']['name'];
          echo '<li class="entity">';
          printf('<a href="#" data-type="entities" data-id=%s>',
            $entity_id);
          printf('<span class="name">%s</span>', $entity_name);
          echo ' in ';
          printf('<span class="location">%s</span>', $place_name);
          echo ' is ';
          printf('<span class="type %s">%s</span>', $entity_type,
            $entity_type);
          echo '</a>';
          echo '</li>';
        }
      } else {
        echo '<li><div class="alert alert-info">No entities have been created.</div></li>';
      }
      ?>
      <li class="divider"></li>
      <li class="nav-header">Hypotheses</li>      
    </ul>
  </div>
  
  <!-- right -->
  <div class="span9 right">
    <div id="canvas"></div>
  </div>
</div>

<!-- add place modal -->
<div class="modal fade" id="add_place">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Add a New Place</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Place',
      array('controller'=>'places', 'action'=>'create'));
    echo $this->BootstrapForm->input('name', array('label'=>false));
    if(isset($places) && $places != null) {
      echo $this->BootstrapForm->input('parent_id',
        array('options'=>$place_list, 'label'=>'in'));
    }
    echo $this->BootstrapForm->input('qmodel_id',
      array('type'=>'hidden', 'value'=>$model['Qmodel']['id']));
    echo '</form>';
    ?>    
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" data-dismiss="modal" class="btn btn-primary">Save Changes</a>
  </div>
</div>

<!-- add entity modal -->
<div class="modal fade" id="add_entity">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Add a New Entity</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Entity',
      array('controller'=>'entity', 'action'=>'create'));
    echo $this->BootstrapForm->input('name', array('label'=>false));
    echo $this->BootstrapForm->input('place_id',
      array('options'=>$place_list, 'label'=>'in'));
    echo $this->BootstrapForm->input('type', 
      array('options'=>$entity_types, 'label'=>'is'));
    echo $this->BootstrapForm->input('qmodel_id',
      array('type'=>'hidden', 'value'=>$model['Qmodel']['id']));
    echo '</form>';
    ?>    
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" data-dismiss="modal" class="btn btn-primary">Save Changes</a>
  </div>
</div>
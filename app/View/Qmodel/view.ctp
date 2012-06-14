<?
$this->start('css');
echo $this->Html->css('view');
$this->end();

$this->start('scripts');
echo $this->Html->script('d3.v2.min.js');
echo $this->Html->script('view');
echo $this->Html->script('edit-item');

// commented out for now -- need to refactor this into several
// different files 
// echo $this->Html->script('drawing');
// echo $this->Html->script('drawing-facts');
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
  json.entities = [
<?
foreach($entities as $entity) {
  $e = $entity['Entity'];
  printf("    { id: %d, name: '%s', x: %d, y: %d, location: %d, type: '%s' },\n",
    $e['id'], $e['name'], $e['x'], $e['y'], $e['place_id'], $e['type']);
}
?>
  ];
  json.links = [
<?
foreach($links as $link) {
  $l = $link['Link'];
  printf("    { id: %d, start: { id: %d, pos: {} }, end: { id: %d, pos: {} }, type: '%s'},\n",
    $l['id'], $l['target_id'], $l['source_id'], $l['type']);
}
?>
  ];
  json.facts = [
<?
foreach($facts as $fact) {
  $f = $fact['Fact'];
  printf("    { id: %d, start: { id: %d, pos: {} }, end: { id: %d, pos: {} }, type: '%s'},\n",
    $f['id'], $f['target_id'], $f['source_id'], $f['type']);
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
          printf('<a href="#" data-type="places" data-id="%s" data-parent="%s" data-name="%s">', 
            $place_id, $parent_id, $place_name);            
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
          printf('<a href="#" data-id="%s" data-name="%s" data-type="%s" data-place-id="%s">',
            $entity_id, $entity_name, $entity_type, $place_id);
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
      <?
      if($links != null) {
        foreach($links as $link) {
          $link_id = $link['Link']['id'];
          $link_type = $link['Link']['type'];
          $source_id = $link['Source']['id'];
          $source_name = $entity_list[$source_id];
          $source_type = $link['Source']['type'];
          $target_id = $link['Target']['id'];
          $target_name = $entity_list[$target_id];
          $target_type = $link['Target']['type'];
          echo '<li class="link">';
          printf('<a href="#" data-type="links" data-id="%s">', $link_id);
          printf('<span class="source %s">%s</span>', $source_type,
            $source_name);
          printf(' <span class="type %s">%s</span>', $link_type, $link_type);
          echo ' with ';
          printf('<span class="target %s">%s</span>', $target_type,
            $target_name);
          echo '</a>';
          echo '</li>';
        }
      } else {
        echo '<li><div class="alert alert-info">No hypotheses have been created.</div></li>'; 
      }
      ?>
      <li class="divider"></li>
      <li class="nav-header">Empirical Facts</li>
      <?
      if($facts != null) {
        foreach($facts as $fact) {
          $fact_id = $fact['Fact']['id'];
          $fact_type = $fact['Fact']['type'];
          $source_id = $fact['Source']['id'];
          $source_name = $entity_list[$source_id];
          $source_type = $fact['Source']['type'];
          $target_id = $fact['Target']['id'];
          $target_name = $entity_list[$target_id];
          $target_type = $fact['Target']['type'];
          echo '<li class="fact">';
          printf('<a href="#" data-type="links" data-id="%s">', $fact_id);
          printf('<span class="source %s">%s</span>', $source_type,
            $source_name);
          printf(' <span class="type %s">%s</span>', $fact_type, $fact_type);
          echo ' with ';
          printf('<span class="target %s">%s</span>', $target_type,
            $target_name);
          echo '</a>';
          echo '</li>';
        }
      } else {
        echo '<li><div class="alert alert-info">No empirical facts have been created.</div></li>'; 
      }
      ?>
    </ul>
  </div>
  
  <!-- observations -->
  <div class="span6 facts hidden">
    <div id="facts"></div>
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

<!-- edit place modal -->
<div class="modal fade" id="edit_place">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Edit Place</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Place',
      array('controller'=>'places', 'action'=>'update'));
    echo $this->BootstrapForm->input('id', array('type'=>'hidden'));
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
    <?
    echo $this->Html->link('Delete', array('controller'=>'places', 
      'action'=>'delete'), array('class'=>'btn btn-danger btn-delete'),
      'Are you sure you want to delete this place? This cannot be undone.');
    ?>
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

<!-- edit entity modal -->
<div class="modal fade" id="edit_entity">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Edit Entity</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Entity',
      array('controller'=>'entity', 'action'=>'update'));
    echo $this->BootstrapForm->input('id', array('type'=>'hidden'));
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
    <?
    echo $this->Html->link('Delete', array('controller'=>'entities', 
      'action'=>'delete'), array('class'=>'btn btn-danger btn-delete'),
      'Are you sure you want to delete this entity? This cannot be undone.');
    ?>
    <a href="#" data-dismiss="modal" class="btn btn-primary">Save Changes</a>
  </div>
</div>

<!-- add link modal -->
<div class="modal fade" id="add_link">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Add a New Hypothesis</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Link',
      array('controller'=>'links', 'action'=>'create'));
    echo $this->BootstrapForm->input('source_id', 
      array('options'=>$entity_list, 'label'=>''));
    echo $this->BootstrapForm->input('type',
      array('options'=>$link_types, 'label'=>''));
    echo $this->BootstrapForm->input('target_id', 
      array('options'=>$entity_list, 'label'=>'with'));
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

<!-- add fact modal -->
<div class="modal fade" id="add_fact">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Add a New Empirical Fact</h3>
  </div>
  <div class="modal-body">
    <?
    echo $this->BootstrapForm->create('Fact',
      array('controller'=>'facts', 'action'=>'create'));
    echo $this->BootstrapForm->input('source_id', 
      array('options'=>$entity_list, 'label'=>''));
    echo $this->BootstrapForm->input('type',
      array('options'=>$link_types, 'label'=>''));
    echo $this->BootstrapForm->input('target_id', 
      array('options'=>$fact_list, 'label'=>'with'));
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

<!-- navbar at top -->
<div class="subnav subnav-fixed">
  <div class="container">
    <ul class="nav nav-pills">
      <li><a href="#add_place" data-toggle="modal">Add Place</a></li>
      <li><a href="#add_entity" data-toggle="modal">Add Entity</a></li>
      <li><a href="#add_link" data-toggle="modal">Add Hypothesis</a></li>
      <li><a href="#add_fact" data-toggle="modal">Add Empirical Fact</a></li>
      <li><a href="#" class="toggle_text">Hide Text</a></li>
      <li><a href="#" class="toggle_model">Hide Graphics</a></li>
      <li><a href="#" class="toggle_facts">Show Facts</a></li>
    </ul>    
  </div>
</div>
<?
$this->start('scripts');
echo $this->Html->script('view');
$this->end();
?>

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
  <div class="span3 well">
    <div class="">
      <h6>Places</h6>
      <?
      if(!isset($places))
        echo '<div class="alert alert-info">No places have been created.</div>';
      ?>
    </div>
    <div class="entities">
      <h6>Entities</h6>
      <?
      if(!isset($entities))
        echo '<div class="alert alert-info">No entities have been created.</div>';
      ?>
    </div>
    <div class="links">
      <h6>Links</h6>
      <?
      if(!isset($links))
        echo '<div class="alert alert-info">No links have been created.</div>';
      ?>
    </div>
  </div>
  
  <!-- right -->
  <div class="span9">
    <div id="canvas"></div>
  </div>
</div>

<div class="navbar secondary navbar-fixed-bottom">
  <div class="navbar-inner">
    <div class="container">
      <ul class="nav">
        <li><a href="#add_place" data-toggle="modal">Add Place</a></li>
        <li><a href="#">Add Entity</a></li>
        <li><a href="#">Add Link</a></li>
      </ul>
    </div>
  </div>
</div>

<!-- modal dialogs -->
<div class="modal fade" id="add_place">
  <div class="modal-header">
    <button class="close" data-dismiss="modal">&times;</button>
    <h3>Add a New Place</h3>
  </div>
  <div class="modal-body">
    <?
    $place_url = $this->Html->url(array('controller'=>'places', 
      'action'=>'create'));
    echo $this->BootstrapForm->create('Place');
    echo $this->BootstrapForm->input('name');
    echo $this->BootstrapForm->input('url', array('value'=>$place_url,
      'type'=>'hidden'));
    if(isset($places))
      echo $this->BootstrapForm->input('parent_id', array('options'=>$places_list));
    ?>    
    </form>
  </div>
  <div class="modal-footer">
    <a href="#" data-dismiss="modal" class="btn">Close</a>
    <a href="#" data-dismiss="modal" class="btn btn-primary">Save Changes</a>
  </div>
</div>


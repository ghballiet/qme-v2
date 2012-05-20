<div class="page-header">
  <?
  echo $this->Html->link('Add Model', array('controller'=>'qmodels', 
    'action'=>'create'), array('class'=>'btn btn-success pull-right'));  
  ?>
  <h1>Your Models <small><? echo count($models); ?> model(s) found</small></h1>
</div>

<table class="table table-condensed">
  <?
  echo $this->Html->tableHeaders(array('Name', 'Description', ''));
  foreach($models as $model) {
    $id = $model['Qmodel']['id'];
    $name = $model['Qmodel']['name'];
    $short_name = $model['Qmodel']['short_name'];
    $desc = $model['Qmodel']['description'];
        
    $btns = '';

    // view
    $btns .= $this->Html->link('View', array('controller'=>'qmodels', 
      'action'=>'view', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini btn-primary'));
    $btns .= ' ';

    // edit
    $btns .= $this->Html->link('Edit', array('controller'=>'qmodels',
      'action'=>'edit', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini'));
    $btns .= ' ';

    // delete
    $btns .= $this->Html->link('Delete', array('controller'=>'qmodels',
      'action'=>'delete', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini btn-danger'), 'Are you sure you want to delete ' .
      'this model?');
    
    echo $this->Html->tableCells(array(
      $name,
      $desc,
      $btns
    ));
  }
  ?>
</table>


<div class="page-header">
  <h1>Public Models <small><? echo count($public_models); ?> model(s) found</small></h1>
</div>

<table class="table table-condensed">
  <?
  echo $this->Html->tableHeaders(array('Name', 'Description', ''));
  foreach($public_models as $model) {
    $id = $model['Qmodel']['id'];
    $name = $model['Qmodel']['name'];
    $short_name = $model['Qmodel']['short_name'];
    $desc = $model['Qmodel']['description'];
        
    $btns = '';

    // view
    $btns .= $this->Html->link('View', array('controller'=>'qmodels', 
      'action'=>'view', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini btn-primary'));
    $btns .= ' ';

    
    echo $this->Html->tableCells(array(
      $name,
      $desc,
      $btns
    ));
  }
  ?>
</table>
<div class="page-header">
  <?
  echo $this->Html->link('Add Model', array('controller'=>'qmodels', 
    'action'=>'create'), array('class'=>'btn btn-success pull-right'));  
  ?>
  <h1>Your Models</h1>
</div>

<table class="table table-condensed">
  <?
  echo $this->Html->tableHeaders(array('Name', 'Description', ''));
  foreach($models as $model) {
    $id = $model['Qmodel']['id'];
    $name = $model['Qmodel']['name'];
    $short_name = $model['Qmodel']['short_name'];
    $desc = $model['Qmodel']['description'];
    
    // TODO: add code here to build a button group, which is the last 
    // column in the cell. it contains three buttons, View, Edit, and
    // Delete. these should all be mini buttons.
    $btns = '<div class="btn-toolbar">';
    // view
    $btns .= '<div class="btn-group">';
    $btns .= $this->Html->link('View', array('controller'=>'qmodels', 
      'action'=>'view', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini btn-primary'));
    $btns .= '</div>';
    // edit
    $btns .= '<div class="btn-group">';
    $btns .= $this->Html->link('Edit', array('controller'=>'qmodels',
      'action'=>'edit', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini'));
    $btns .= '</div>';
    // delete
    $btns .= '<div class="btn-group">';
    $btns .= $this->Html->link('Delete', array('controller'=>'qmodels',
      'action'=>'delete', 'short_name'=>$short_name), array('class'=>
      'btn btn-mini btn-danger'), 'Are you sure you want to delete ' .
      'this model?');
    $btns .= '</div>';
    
    $btns .= '</div>';
    
    echo $this->Html->tableCells(array(
      $name,
      $desc,
      $btns
    ));
  }
  ?>
</table>
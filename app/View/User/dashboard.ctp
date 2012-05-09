<div class="page-header">
  <?
  echo $this->Html->link('Add Model', array('controller'=>'qmodels', 
    'action'=>'create'), array('class'=>'btn btn-success pull-right'));  
  ?>
  <h1>Your Models</h1>
</div>

<table class="table">
  <?
  echo $this->Html->tableHeaders(array('Name', 'Description'));
  foreach($models as $model) {
    $name = $model['Qmodel']['name'];
    $desc = $model['Qmodel']['description'];
    
    // TODO: add code here to build a button group, which is the last 
    // column in the cell. it contains three buttons, View, Edit, and
    // Delete. these should all be mini buttons.
    
    echo $this->Html->tableCells(array(
      $name,
      $desc
    ));
  }
  ?>
</table>
<?
$this->start('scripts');
echo $this->Html->script('create');
$this->end();
?>

<div class="page-header">
  <h1>Add New Model</h1>
</div>

<? echo $this->BootstrapForm->create('Qmodel'); ?>
<fieldset>
  <?
  echo $this->BootstrapForm->input('name', array('autofocus'=>true));
  echo $this->BootstrapForm->input('short_name', array('readonly'=>true));
  echo $this->BootstrapForm->input('description');
  echo $this->BootstrapForm->input('user_id', array('type'=>'hidden', 
    'value'=>$user['id']));
  echo $this->BootstrapForm->input('private', array('value'=>false));
  echo $this->BootstrapForm->end('Add Model');
  ?>
</fieldset>
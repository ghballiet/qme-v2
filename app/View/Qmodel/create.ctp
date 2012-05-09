<div class="page-header">
  <h1>Add New Model</h1>
</div>

<? echo $this->BootstrapForm->create('Qmodel'); ?>
<fieldset>
  <?
  echo $this->BootstrapForm->input('name', array('autofocus'=>true));
  echo $this->BootstrapForm->input('description');
  echo $this->BootstrapForm->input('user_id', array('type'=>'hidden', 
    'value'=>$user['id']));
  echo $this->BootstrapForm->end('Add Model');
  ?>
</fieldset>
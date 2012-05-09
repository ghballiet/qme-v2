<div class="page-header">
  <h1>Create an Account</h1>
</div>

<? echo $this->BootstrapForm->create('User'); ?>
<fieldset>
  <?
  echo $this->BootstrapForm->input('name', array('autofocus'=>'true'));
  echo $this->BootstrapForm->input('surname');
  echo $this->BootstrapForm->input('email', array('type'=>'email'));
  echo $this->BootstrapForm->input('confirm_email', array('type'=>
    'email'));
  echo $this->BootstrapForm->input('password');
  echo $this->BootstrapForm->input('confirm_password', array('type'=>
    'password'));
  echo $this->BootstrapForm->end('Register');
  ?>
</fieldset>
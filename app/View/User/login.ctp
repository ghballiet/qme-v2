<div class="page-header">
  <h1>Please log in to continue.</h1>
</div>

<?
echo $this->BootstrapForm->create('User');
?>
<fieldset>
  <div class="control-group">
    <div class="controls">
      <p class="help-block">Don't have an account? 
        <? echo $this->Html->link('Register Now',
          array('action'=>'register'), array('class'=>'btn')); ?>
        </p>
    </div>
  </div>
  <?
  echo $this->BootstrapForm->input('email', array('type'=>'email',
    'autofocus'=>'true'));
  echo $this->BootstrapForm->input('password', array());
  echo $this->BootstrapForm->end('Login');
  ?>
</fieldset>
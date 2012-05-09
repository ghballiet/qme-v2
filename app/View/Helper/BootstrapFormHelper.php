<?
App::uses('AppHelper', 'View/Helper');

class BootstrapFormHelper extends AppHelper {
  private $model = null;
  
  public $helpers = array('Form', 'Html');

  public function create($model, $opts = null) {
    $this->model = $model;
    $options = array(
      'inputDefaults'=>array(
        'required'=>'true',
        'div'=>false,
        'label'=>false),
      'class'=>'form-horizontal');
    if($opts == null)
      $opts = array();
    $opts = array_merge($opts, $options);
    return $this->Form->create($model, $opts);
  }
  
  public function end($value) {
    $str = '';
    $str .= '<div class="form-actions">';
    $str .= $this->Form->end(array('label'=>$value, 'value'=>$value, 
      'class'=>'btn btn-primary', 'name'=>$value));
    $str .= '</div>';
    return $str;
  }

  public function input($name, $opts = null) {
    $label = ucwords(str_replace('_', ' ', $name));
    // set the error stuff in the opts
    $opts['error'] = array('attributes'=>array('wrap'=>'span', 'class'=>'help-inline error'));
    
    if(isset($opts['label'])) {
      $label = $opts['label'];
      $opts['label'] = false;
    }
    $id = preg_replace('/[\W|_]/', ' ', $name);
    $id = sprintf('%s %s', $this->model, $id);
    $id = str_replace(' ', '', ucwords($id));
    $str = '';
    $str .= '<div class="control-group">';
    $str .= sprintf('<label for="%s" class="control-label">%s</label>',
      $id, $label);
    $str .= '<div class="controls">';
    if(isset($opts['icon'])) {
      $str .= '<div class="input-prepend">';
      $str .= sprintf('<span class="add-on"><i class="icon-%s"></i></span>',
        $opts['icon']);
      $str .= $this->Form->input($name, $opts);
      $str .= '</div>';
    } else {
      $str .= $this->Form->input($name, $opts);
    }
    $str .= '</div>';
    $str .= '</div>';
    return $str;
  }
}
?>
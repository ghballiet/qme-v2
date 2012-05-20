<?
class EntitiesController extends AppController {
  public $name = 'Entity';
  
  public function create() {
    if($this->request->is('post') &&
      $entity = $this->Entity->save($this->request->data)) {
      $place = $this->Entity->Place->findById($entity['Entity']['place_id']);
      $short_name = $place['Qmodel']['short_name'];
      $this->alertSuccess('Success!', sprintf('Successfully created ' . 
        '<strong>%s</strong>.', $entity['Entity']['name']), true);
      $this->redirect(array('controller'=>'qmodels', 'action'=>'view', 
        'short_name'=>$short_name));
    }
  }
  
  public function update() {
    $this->layout = 'ajax';
    if($this->request->is('post') &&
      $entity = $this->Entity->save($this->request->data)) {
      $place = $this->Entity->Place->findById($entity['Entity']['place_id']);
      $short_name = $place['Qmodel']['short_name'];
      $this->redirect(array('controller'=>'qmodels', 'action'=>'view', 
        'short_name'=>$short_name));
    } else {
      echo 'FAILURE :(';
    }
  }
  
  public function delete($id = null) { 
    $this->Entity->id = $id;
    $entity = $this->Entity->read();
    $place = $this->Entity->Place->findById($entity['Entity']['place_id']);
    $short_name = $place['Qmodel']['short_name'];
    
    $this->Entity->delete($id);
    $this->alertSuccess('Success!', sprintf('Successfully deleted ' . 
      '<strong>%s</strong>.', $entity['Entity']['name']), true);
    $this->redirect(array('controller'=>'qmodels', 'action'=>'view', 
      'short_name'=>$short_name));
  }
}
?>
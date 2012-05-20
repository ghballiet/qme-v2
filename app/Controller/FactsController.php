<?
class FactsController extends AppController {
  public $name = 'Fact';
  
  public function create() {
    if($this->request->is('post') &&
      $fact = $this->Fact->save($this->request->data)) {
      $model = $this->Fact->Qmodel->findById($fact['Fact']['qmodel_id']);
      $short_name = $model['Qmodel']['short_name'];
      $this->alertSuccess('Success!', 'Successfully added fact.', true);
      $this->redirect(array('controller'=>'qmodels', 'action'=>'view', 
        'short_name'=>$short_name));
    }
  }
  
  public function update() {
    
  }
  
  public function delete() {
    
  }
}
?>
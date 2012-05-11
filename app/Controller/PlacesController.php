<?
class PlacesController extends AppController {
  public $name = 'Place';
  
  public function beforeFilter() {
    $this->layout = 'ajax';
  }
  
  public function create() {
    if($this->request->is('post') &&
      $place = $this->Place->save($this->request->data)) {
      $model = $this->Place->Qmodel->findById($place['Place']['qmodel_id']);
      $short_name = $model['Qmodel']['short_name'];
      $this->alertSuccess('Success!', sprintf('Successfully created ' . 
        '<strong>%s</strong>.', $place['Place']['name']), true);
      $this->redirect(array('controller'=>'qmodels',
        'action'=>'view', 'short_name'=>$short_name));
    }
  }
}
?>
<?
class QmodelsController extends AppController {
  public $name = 'Qmodel';
  
  function beforeFilter() {
    $this->set('user', $this->Auth->user());
  }
  
  function create() {
    if($this->request->is('post') &&
      $model = $this->Qmodel->save($this->request->data)) {
      $this->alertSuccess('Success!', sprintf('Successfully created ' . 
        '<strong>%s</strong>.', $model['Qmodel']['name']), true);
      $this->redirect(array('controller'=>'users',
        'action'=>'dashboard'));
    }
  }
  
  function edit($short_name = null) {
    
  }
  
  function delete($short_name = null) {
    
  }
  
  function view($short_name = null) {
    $model = $this->Qmodel->findByShortName($short_name);
    $model_id = $model['Qmodel']['id'];
    
    // ---- places ----
    $place_options = array(
      'conditions'=>array('Place.qmodel_id'=>$model_id),
      'order'=>array('Parent.name', 'Place.name')
    );
    $places = $this->Qmodel->Place->find('all', $place_options);
    $place_options['order'] = array('Place.name');
    $place_list = $this->Qmodel->Place->find('list', $place_options);
    
    // ---- entities ----
    $entity_options = array(
      'conditions'=>array('Entity.place_id'=>array_keys($place_list)),
      'order'=>array('Place.name', 'Entity.name')
    );
    $entities = $this->Qmodel->Place->Entity->find('all', $entity_options);
    $entity_options['order'] = array('Entity.name');
    $entity_list = $this->Qmodel->Place->Entity->find('list', $entity_options);
    $entity_types = array('stable'=>'stable', 'transient'=>'transient');

    $this->set('model', $model);
    $this->set('places', $places);
    $this->set('place_list', $place_list);
    $this->set('entities', $entities);
    $this->set('entity_list', $entity_list);
    $this->set('entity_types', $entity_types);
  }
}
?>
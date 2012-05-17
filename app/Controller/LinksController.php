<?
class LinksController extends AppController {
  public $name = 'Link';
  
  public function create() {
    if($this->request->is('post') && $link = $this->Link->save($this->request->data)) {
      $model = $this->Link->Qmodel->findById($link['Link']['qmodel_id']);
      $short_name = $model['Qmodel']['short_name'];
      $this->alertSuccess('Success!', sprintf('Successfully added link.'), true);
      $this->redirect(array('controller'=>'qmodels',
        'action'=>'view', 'short_name'=>$short_name));
    }
  }
}
?>
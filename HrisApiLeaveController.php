<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

class HrisApiLeaveController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Auth');
          $this->Auth->config('authenticate', [
          'Form' => ['userModel' => 'Employees','finder' => 'auth']
      ]);
        $this->Auth->allow(['autoUnlockAccounts','getClients','mailActions','autoLogin','authlogin','login']);
        
       

    }

    public function home()
    {

       
        
        $hrisClient = $this->HrisApiLeave->find('all')
                    ->select($this->HrisApiLeave)
                    ->select(['clientName'=>'hac.name','host'=>'hac.host','username'=>'hacr.username','database'=>'hac.database','password'=>''])
                    ->join([
                        'hac' =>[
                            'table'=>'hris_api_clients',
                            'type' => 'LEFT',
                            'conditions' => 'hac.id = HrisApiLeave.client_id'
                        ]
                        
                        ]);

                       
        
        $data = array();
        $i=0;
        foreach($hrisClients as $k => $v){
            $clients =TableRegistry::get('hris_api')->find()->where(['status'=>1,'id'=>$v->client_id])->hydrate(false)->first(); 
           
            $this->changeDBConnection($clients);  
            $data[$i]['clients'] = $v->clientName;
            $data[$i]['id'] = $v->id;

            $section =TableRegistry::get('profile_sections')->find()->where(['status'=>1,'id'=>$v->profile_section_id])->hydrate(false)->first(); 
            

            $data[$i]['section'] = $section['label'];
            $i++;
        }
    
   

        $this->set(compact('data'));
    }

    public function view($id = null)
    
    {
       
        $hrisClient = $this->HrisApiLeave->find('all')
        ->select($this->HrisApiLeave)
        ->select(['clientName'=>'hac.name','host'=>'hac.host','username'=>'hac.username','database'=>'hac.database','password'=>'hac.password'])
       
        $leave_id =  explode(',',$hrisClient->leaveID);
        $color =  $hrisClient->color;

        $clients =TableRegistry::get('hris_api_clients')->find()->where(['status'=>1,'id'=>$hrisClient->client_id])->hydrate(false)->first(); 

        $this->changeDBConnection($clients);

        $leavs =TableRegistry::get('leave_type')->find()->where(['status'=>1,'id IN'=>$leave_id]); 

        $this->set(compact('hrisClient','leavs','color'));
    }
    public function array_object($arr) {
        $arrObject = array();

        for ($i=0;$i<=count($arr);$i++) {
           
           $array = $arr[$i];
            foreach ($array as $key => $value) {
               
                $arrObject[] =  $value;
            }
            
        }
    
        return $arrObject;
    }

    public function add()
    {
        $hrisClient = $this->HrisApi->newEntity();
        if ($this->request->is('post')) {
            $employee_id = $this->Auth->user('emp_id');
            $d  = $this->request->getData();

            $leavArr = array();
            for($i=0; $i<count($d['ordering']); $i++){
                $leavArr[$d['ordering'][$i]][] = $d['leave_id'][$i];
            }
            
            $order_l = $this->array_to_object($leavArr);

            $data['leaveID'] = implode(',',$order_l);
            $data['order'] = implode(',',$d['ordering']);
            $data['color'] = implode(',',$d['color']);
            $data['client_id'] = $d['client_id'];
            $data['created_by'] = $employee_id;
            $data['created_at']     = date('y-m-d H:i:s');
            $hrisClient = $this->HrisApiLeave->patchEntity($hrisClient, $data);
            if ($this->HrisApiLeave->save($hrisClient)) {
                $this->Flash->success(__('Data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Data could not be saved. Please, try again.'));
        }
        $clients =TableRegistry::get('hris_api')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['status'=>1])->hydrate(false)->toArray(); 
      // echo "<pre>"; print_r($clients);die;
        $this->set(compact('clients'));
    }

    public function leaveType(){
        
        $clients =TableRegistry::get('hris_api')->find()->where(['status'=>1,'id'=>$_POST['client_id']])->hydrate(false)->first(); 

        $this->changeDBConnection($clients);

        $fields =TableRegistry::get('leave_type')->find('list', [
            'keyField' => 'id',
            'valueField' => 'name'
        ])->where(['status'=>1])->hydrate(false)->toArray();

        
        $data['fields'] = $fields;
        

        echo json_encode($data);
        exit;

    }

    public function section(){
        
        $clients =TableRegistry::get('hris_api')->find()->where(['status'=>1,'id'=>$_POST['id']])->hydrate(false)->first(); 

        $this->changeDB($clients);
        $section_id = array(1,2);
        $section =TableRegistry::get('profile_sections')->find('list', [
            'keyField' => 'id',
            'valueField' => 'label'
        ])->where(['status'=>1,'id in'=>$section_id])->hydrate(false)->toArray();

        
        $data['section'] = $section;
       

        echo json_encode($data);
        exit;

    }

    public function edit($id = null)
    {
        $hrisClient = $this->HrisApi->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee_id            = $this->Auth->user('emp_id');
            $d                  = $this->request->getData();

            $leavArr = array();
            for($i=0; $i<count($d['ordering']); $i++){
                $leavArr[$d['ordering'][$i]][] = $d['leave_id'][$i];
            }
            
            $order_l = $this->array_to_object($leavArr);

            $data['leaveID'] = implode(',',$order_l);
            $data['order'] = implode(',',$d['ordering']);
            $data['color'] = implode(',',$d['color']);
            $data['client_id'] = $d['client_id'];
            $data['updated_by'] = $employee_id;
            $data['updated_at']     = date('y-m-d H:i:s');
            //print_r($data);die;
            $hrisClient = $this->HrisApiLeave->patchEntity($hrisClient, $data);
            if ($this->HrisApiLeave->save($hrisClient)) {
                $this->Flash->success(__('Data has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Data could not be saved. Please, try again.'));
        }
        $clients =TableRegistry::get('hris_api_clients')->find()->where(['status'=>1])->hydrate(false)->toArray(); 
        $this->set(compact('clients','hrisClient'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $hrisClient = $this->HrisApi->get($id);
        if ($this->HrisApi->delete($hrisClient)) {
            $this->Flash->success(__('Data has been deleted.'));
        } else {
            $this->Flash->error(__('Data could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

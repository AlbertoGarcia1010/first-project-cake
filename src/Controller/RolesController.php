<?php 


namespace App\Controller;

use Cake\Log\Log;
use App\Controller\PrivateBaseController;
use Cake\ORM\TableRegistry;
use Exception;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RolesController extends PrivateBaseController
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Modificar la solicitud o preparar una respuesta
        $response = $handler->handle($request);

        // Modificar la respuesta antes de devolverla
        return $response->withHeader('X-Custom-Header', 'MyValue');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
{
    parent::beforeFilter($event);
/*
    // Permitir CORS
    $this->response = $this->response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');

    // Si es una solicitud OPTIONS, devolver una respuesta rápida
    if ($this->request->getMethod() === 'OPTIONS') {
        $this->response = $this->response->withStatus(200);
        return $this->response;
    }
    */
}

    public function viewRoles(){
        // $this->set('Test', "Test");
        // $this->render( 'viewRoles');
        //$this->viewBuilder()->setTemplatePath('Roles');
        /*
        // Permitir CORS
    $this->response = $this->response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
    ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');
    */

    }

    public function create(){
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            $customHeaderValue = $this->request->getHeaders();
            Log::info("Headers: ".json_encode($customHeaderValue));
            $rol = $this->Roles->newEmptyEntity();

            if($this->request->is('post')){
                $rol = $this->Roles->patchEntity($rol, $this->request->getData());
                $rol->is_visible = 1;
                $rol->id_status = 1;
                Log::info("rol: $rol");
    
                if($this->Roles->save($rol)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'viewRoles']);
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('rol'));
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
    }
    public function getAll(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            
            $rolesTable = TableRegistry::getTableLocator()->get('Roles');

            // Get query parameters sent by DataTables
            $start = $this->request->getQuery('start');
            $length = $this->request->getQuery('length');
            $search = $this->request->getQuery('search')['value'];
            Log::info("search: $search");


            if($search == null){
                $query = $this->Roles->find('all');
            }else{
                $query = $this->Roles->find()->where([
                    'OR' => [
                        'Roles.name LIKE' => '%'. $search .'%',
                        'Roles.description LIKE' => '%'. $search .'%',
                    ]
                ]);
            }
            
            Log::info("Query: $query");
            //$query = $rolesTable->find()->where(['Roles.is_visible' => 1]);

            // Get total number of filtered records
            $totalFiltered = $query->count();

            // Get total number of records in the table
            $totalData = $rolesTable->find()->count();

            // Get the actual data
            $roles = $query->all()->toArray();
            Log::info("Roles: ".json_encode($roles));

            $data = [];
            foreach ($roles as $rol) {
                $data[] = [
                    $rol->rol_id,
                    $rol->name,
                    $rol->description,
                    $rol->id_status
                    //$rol->created->format('Y-m-d H:i:s')
                ];
            }

            // Return the data in JSON format
            $jsonData = [
                "draw" => intval($this->request->getQuery('draw')), // Draw counter sent by DataTables
                "recordsTotal" => $totalData, // Total number of records
                "recordsFiltered" => $totalFiltered, // Number of filtered records
                "data" => $data // Actual data to display
            ];
            
            //$this->set('jsonData', $jsonData);
            //$this->viewBuilder()->setOption('serialize', ['jsonData']);
            
    
            /*
            $cakes = [
                ['name' => 'Chocolate Cake', 'price' => 20],
                ['name' => 'Vanilla Cake', 'price' => 15],
            ];
            */
            
    
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $jsonData];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        return $this->_responseJson($response);
    }

    public function getById(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idRol = $this->request->getData('idRol');
            Log::info("idRol: $idRol");

            $rol = $this->Roles->get($idRol);
            Log::info("rol: $rol");

            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $rol];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        return $this->_responseJson($response);
    }

    public function update(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idRol = $this->request->getData('idRol');
            $name = $this->request->getData('nameEdit');
            $description = $this->request->getData('descriptionEdit');
            Log::info("idRol: $idRol");

            $rol = $this->Roles->get($idRol);
            $rol->name = $name;
            $rol->description = $description;
            Log::info("rol: $rol");

            if($this->request->is('post')){
                $rol = $this->Roles->patchEntity($rol, $this->request->getData());
    
                if($this->Roles->save($rol)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('rol'));
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $rol];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        return $this->_responseJson($response);
    }

    public function delete(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $this->viewBuilder()->disableAutoLayout();
            $idRol = $this->request->getData('idRol');
            Log::info("idRol: $idRol");

            $rol = $this->Roles->get($idRol);
            Log::info("rol: $rol");

            if($this->request->is('post')){    
                if($this->Roles->delete($rol)){
                    $this->Flash->success(__('Se han eliminado los datos.'));
                }
    
                $this->Flash->error(__('Hubo un error al eliminar los datos'));
            }
    
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => ''];
            
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        return $this->_responseJson($response);
    }

    public function add(){
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            
            $rol = $this->Roles->newEmptyEntity();

            if($this->request->is('post')){
                $rol = $this->Roles->patchEntity($rol, $this->request->getData());
    
                if($this->Roles->save($rol)){
                    $this->Flash->success(__('Se han guardado los datos.'));
                    return $this->redirect(['action' => 'viewRoles']);
                }
    
                $this->Flash->error(__('Hubo un error al guardar los datos'));
            }
    
            $this->set(compact('rol'));
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }

        return $this->_responseJson($response);

    }
    public function testCake(){
        
        try{
            Log::info( "Controller: ".$this->request->getParam('controller')."| Action: ".$this->request->getParam('action')."| IP: ".$this->request->clientIp()."| URL: ".$this->request->getUri()."| isAjax: ".($this->request->is('ajax') ? "Y":"N")."|isJson: ".($this->request->is('json') ? "Y":"N")."| Agent: " . $this->request->getHeaderLine('User-Agent'));
            $this->viewBuilder()->disableAutoLayout();
            $customHeaderValue = $this->request->getHeaders();
            Log::info("Headers: ".json_encode($customHeaderValue));
            $appToken = env('APP_TOKEN');
            Log::info("APP-TOKEN: $appToken");
    
            $cakes = [
                ['name' => 'Chocolate Cake', 'price' => 20],
                ['name' => 'Vanilla Cake', 'price' => 15],
            ];
            
    
            $response = ['success' => true, 'metadata' => ['id' => 1, 'message' => 'Request was successful'], 'data' => $cakes];
        } catch (Exception $e) {
            Log::warning("Exception|Code: " . $e->getCode() . "|Line: " . $e->getLine() . "|Msg: " . $e->getMessage());
            $response = ['success' => true, 'metadata' => ['id' => -2, 'message' => 'Ocurrio un error']];
        }
        
        return $this->_responseJson($response);
        
    }
}

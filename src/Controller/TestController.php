<?php 


namespace App\Controller;

use Cake\Log\Log;
use App\Controller\PrivateBaseController;
use Exception;

class TestController extends PrivateBaseController
{
    public function index(){
        // $this->set('Test', "Test");
        // $this->render( 'index');
        $this->viewBuilder()->setTemplatePath('Test');

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

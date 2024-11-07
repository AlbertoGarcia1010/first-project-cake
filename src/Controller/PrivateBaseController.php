<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\InvalidCsrfTokenException;

class PrivateBaseController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
		/*
        // Cargar componentes comunes
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'authError' => 'Por favor, inicia sesión para acceder a esta área.',
            'loginRedirect' => ['controller' => 'Pages', 'action' => 'home'],
            'logoutRedirect' => ['controller' => 'Users', 'action' => 'login']
        ]);
		*/
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Manejo de la excepción CSRF
        //$this->request->allowMethod(['post', 'get', 'put', 'delete']);
        try {
            // Lógica del controlador
        } catch (InvalidCsrfTokenException $e) {
            // Personalizar la respuesta para el error CSRF
            $this->Flash->error('Token CSRF inválido. Por favor, intente nuevamente.');
            return $this->redirect($this->referer());
        }

        $appTokenEnv = env('APP_TOKEN');
        // Set the variable for use in the view
        $this->set(compact('appTokenEnv'));
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
    

	protected function _responseJson($reponse){
		$this->response = $this->response->withType('application/json; charset=UTF-8');
		$this->response = $this->response->withStringBody(json_encode($reponse));
        
        /*
        
        $this->response = $this->response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With, X-CSRF-Token, App-Token');
        */
        
        /*
        $this->response = $this->response->cors($this->request)
                                        ->allowOrigin(['*'])
                                        ->allowMethods(['GET', 'POST'])
                                        ->allowHeaders(['X-CSRF-Token', 'App-Token'])
                                        ->allowCredentials()
                                        ->build();
                                        */
                                        
		return $this->response;
	}
}
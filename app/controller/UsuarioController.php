<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioController extends AppController {
    
    /**
     * Instancia UsuarioModel
     */
    public function __construct() 
    {    
        parent::__construct();
        parent::loadModel('Usuario'); // armaza em $this->model uma instância de UsuarioModel
        $this->templateDir = 'usuario'; // neste atributo está o caminho app/view/usuario
    }
    
    /**
     * Tela principal de usuario
     */
    public function index()
    {        
        if ($this->session->getAttribute('autenticado') === false) {
            $this->flashMessenger->hideAfterShow(true)->message('Usuário não autenticado.', 2); 
            $this->redirect('usuario', 'login');
            return;
        }
        $this->set('usuario', $this->session->getAttribute('usuario'));
        $this->display('index');        
    }
    
    /**
     * Tela de atutenticação
     */
    public function login()
    {
        $this->display('login');
    }
    
    /**
     * Efeuta a autenticação do usuário
     */
    public function efetuarLogin()
    {        
        $this->model->setEmail($this->xssCleaner->cleanInput(Params::post('email', 'string')));
        $this->model->setSenha($this->xssCleaner->cleanInput(Params::post('senha', 'string')));
        if ($this->model->efetuarLogin()) {
            $this->session->setAttribute('autenticado', true);            
            $this->redirect('usuario', 'index');
        } else {
            $this->flashMessenger->message('Usuário e/ou senha incorretos.', 3); 
            $this->redirect('usuario', 'login');
        }        
    }
    
    /**
     * Tela de consulta de usuários
     */
    public function consultar()
    {
        if (count($_POST) > 0) {
            $this->model->setNome(Params::post('nome'));
            $this->model->setEmail(Params::post('email'));
        }
        $this->set('listaUsuarios', $this->model->consultar());
        $this->display('consultar');
    }
    
    /**
     * Tela de cadastro de usuário
     * @return void
     */
    public function cadastrar()
    {
        if ($this->session->getAttribute('autenticado') === false) {
            $this->flashMessenger->message('Usuário não autenticado.', 3);                         
            $this->redirect('usuario', 'login');
            return;
        }
        
        $perfil = new PerfilModel();
        $listaPerfis = $perfil->fetchAll('nome');        
        $this->set('listaPerfis', $listaPerfis);                                
        $this->display('cadastrar');
    }
    
    /**
     * Cadastra um usuário
     */
    public function enviarCadastro()
    {
        if ($this->form->isTokenValid() === false) {
            $this->flashMessenger->message('Formulário inválido.', 2);            
        } else {
            $this->model->setNome($this->xssCleaner->cleanInput(Params::post('nome')));
            $this->model->setEmail($this->xssCleaner->cleanInput(Params::post('email')));        
            $this->model->setPerfil(Params::post('perfil', 'int'));        
            try {
                $this->model->cadastrar();
                $this->flashMessenger->message('Usuário cadastrado com sucesso.', 1);
            } catch (Exception $e) {
                $this->flashMessenger->message($e->getMessage(), 2);               
            }
        }
        $this->redirect('usuario', 'cadastrar');
    }

    /**
     * Encerra a sessão do usuário
     */
    public function sair()
    {
        $this->session->setAttribute('autenticado', false);
        $this->redirect('usuario', 'login');        
    }

    
}
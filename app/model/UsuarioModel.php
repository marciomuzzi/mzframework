<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UsuarioModel extends AppModel {    
    
    /**
     * Seta a dependências da classe
     * entity = classe a qual irá se relacionar
     * id_perfil = campo FK da classe (Usuario, neste caso)
     * id = nome do campo da classe irá se relacionar 
     * (neste caso, "id_perfil" de Usuario se relaciona com "id" de Perfil)
     */
    public function __construct() 
    {
        parent::__construct();
        $this->tabela = 'tb_usuario';
        $this->campoPk = 'id';        
        $this->dependency[] = array( 'entity' => 'Perfil', 
                                         'fk' => 'id_perfil', 
                                         'id' => 'id', 
                                      'fetch' => '1' );
    }
    
    /**
     * Atributo utilizado pelos métodos setter
     * @var array
     */
    private $dadosUsuario = array();
    
    /**
     * Armazena o nome do usuário
     * @param string $param
     */
    public function setNome($param) 
    {
        $this->dadosUsuario['nome'] = strtoupper(Filter::retirarAspasSimples($param));
    }
    
    /**
     * Armazena o e-mail do usuário
     * @param string $param
     */
    public function setEmail($param) 
    {
        $this->dadosUsuario['email'] = strtolower(trim($param));
    }
    
    /**
     * Armazena a senha do usuário
     * @param string $param
     */
    public function setSenha($param) 
    {
        $this->dadosUsuario['senha'] = md5(trim($param));
    }
    
    /**
     * Armazena o código do perfil do usuário
     * @param int $param
     */
    public function setPerfil($param)
    {
        $this->dadosUsuario['idPerfil'] = (int)$param;
    }
    
    /**
     * Verifica o email e senha, e retona os dados do usuário
     * @return array
     */
    public function efetuarLogin() 
    {
        $sql = "SELECT * FROM {$this->tabela} WHERE email = '".$this->dadosUsuario['email']."' AND senha = '".$this->dadosUsuario['senha']."'";                         
        $rsUser = $this->sgbd->fetchArray($sql);                        
        $session = new Session(APP_SIGLA);
        
        $arDadosSession = array();
        $arDadosSession['id']       = $rsUser['id'];
        $arDadosSession['idPerfil'] = $rsUser['id_perfil'];
        $arDadosSession['email']    = $rsUser['email'];
        $arDadosSession['nome']     = $rsUser['nome'];
        
        $session->setAttribute('usuario', $arDadosSession);        
        return $rsUser;
    }
    
    /**
     * Efetua a consukta de de usuário na base de dados.
     * @return array
     */
    public function consultar()
    {
        $sql = "SELECT u.nome, u.email, p.nome as perfil 
                  FROM tb_usuario u
            INNER JOIN tb_perfil p ON u.id_perfil = p.id 
                 WHERE 1=1";
        if (!empty($this->dadosUsuario['nome'])) {
            $sql .= " AND u.nome ILIKE '%{$this->dadosUsuario['nome']}%'";
        }
        if (!empty($this->dadosUsuario['email'])) {
            $sql .= " AND u.email LIKE '%{$this->dadosUsuario['email']}%'";
        }
        
        $rs = $this->sgbd->fetchAll($sql);
        if(!$rs) {
            return array();
        }
        return $rs;
    }
    
    /**
     * Cadastra um usuário
     */
    public function cadastrar() 
    {
        if (empty($this->dadosUsuario['nome']) || empty($this->dadosUsuario['email']) || empty($this->dadosUsuario['idPerfil'])) {
            throw new Exception('Dados obrigatórios não informados.');            
        }
        // @todo Verificar se email já existe.
        $sql = "INSERT INTO {$this->tabela} (nome, email, senha, id_perfil) VALUES ('".$this->dadosUsuario['nome']."', '".$this->dadosUsuario['email']."', '".$this->dadosUsuario['senha']."', ".$this->dadosUsuario['idPerfil'].")";
        $this->sgbd->query($sql);
    }
    
    
}
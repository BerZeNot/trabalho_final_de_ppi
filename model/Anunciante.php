<?php

class Anunciante {
    private $id;
    private $name;
    private $cpf;
    private $email;
    private $password;
    private $confirm_password;
    private $telephone;

    public function __construct($id, $name, $cpf, $email, $password, $confirm_password, $telephone){
        $this->id   = $id;
        $this->name = $name;
        $this->cpf  = $cpf;
        $this->email  = $email;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->telephone = $telephone;
    }

    public function isValid(){
        $validation = array(
            "valid" => true,
            "messages" => []
        );
        
        if($this->name == ""){
            $validation ['valid'] = false;
            array_push($validation['messages'], "Informe o nome");            
        }

        if($this->cpf == "" || strlen($this->cpf) != 11){
            $validation ['valid'] = false;
            array_push($validation['messages'], "O CPF deve ter 11 dígitos");
        }
        
        $emailValido = filter_var($this->email, FILTER_VALIDATE_EMAIL);

        if(!$emailValido || $this->email == ""){
            $validation ['valid'] = false;
            array_push($validation['messages'], "O e-mail é inválido");
        }

        if($this->password == "" || strlen($this->password) < 5){
            $validation ['valid'] = false;
            array_push($validation['messages'], "A senha deve ter pelo menos 5 caracteres");
        }

        if($this->confirm_password == ""){
            $validation ['valid'] = false;
            array_push($validation['messages'], "Confirme a senha");
        }

        if($this->password != $this->confirm_password){
            $validation ['valid'] = false;
            array_push($validation['messages'], "As senhas não batem");
        }

        if($this->telephone == ""){
            $validation ['valid'] = false;
            array_push($validation['messages'], "O telefone deve ser informado");
        }

        return $validation;
    }

    public function getParamsToSave(){
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        
        $params = [
            $this->name,
            $this->cpf,
            $this->email,
            $passwordHash,
            $this->telephone
        ];

        return $params;
    }

    public function getParamsToUpdate(){
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        
        $params = [
            $this->name,
            $this->cpf,
            $passwordHash,
            $this->telephone
        ];

        return $params;
    }

    
    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function getCpf() { return $this->cpf; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getConfirmPassword() { return $this->confirm_password; }
    public function getTelephone() { return $this->telephone; }
}
?>
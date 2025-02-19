<?php

namespace Paw\App\Models;

use Paw\Core\Model;
use Paw\Core\Exceptions\InvalidValueFormatException;
use Paw\Core\Exceptions\MandatoryValueException;

use Exception;

class Usuario extends Model
{
    public $table = 'usuarios';
    public $fields = [
        "nombre" => null,
        "apellido" => null,
        "email" => null,
        "password" => null
    ];
      
    public function setNombre(string $nombre)
    {
        if (is_null($nombre)) {
            throw MandatoryValueException("El nombre es obligatorio.");
        }

        if (strlen($nombre) > 60) {
            throw InvalidValueFormatException("El nombre del paciente no debe ser mayor a 60 caracteres.");
        }
        $this->fields["nombre"] = $nombre; 
    }

    public function setApellido(string $apellido)
    {
        if (is_null($apellido)) {
            throw MandatoryValueException("El apellido es obligatorio.");
        }

        if (strlen($apellido) > 60) {
            throw InvalidValueFormatException("El apellido del paciente no debe ser mayor a 60 caracteres");
        }
        $this->fields["apellido"] = $apellido; 
    }

    public function setEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidValueFormatException("El email del paciente no tiene el formato correcto.");
        }

        if (is_null($email)) {
            throw MandatoryValueException("El email es obligatorio.");
        }

        $this->fields["email"] = $email; 
    }

    public function setPassword(string $password)
    {
        if (is_null($password)) {
            throw MandatoryValueException("La password es obligatorio.");
        }

        $this->fields["password"] = $password;
    }

    public function getNombre()
    {
        return $this->fields["nombre"];
    }

    public function getApellido()
    {
        return $this->fields["apellido"];
    }

    public function getEmail()
    {
        return $this->fields["email"];
    }

    public function getPassword()
    {
        return $this->fields["password"];
    }

    public function passwordHash()
    {
        $hash = password_hash($this->fields['password'], PASSWORD_BCRYPT);

        if (!password_needs_rehash($hash, PASSWORD_BCRYPT)) {
            $hash = password_hash($this->fields['password'], PASSWORD_BCRYPT);
        }

        return $hash;
    }

    public function insert()
    {
        $this->queryBuilder->insert($this->table, $this->fields);
    }

    public function existsUser()
    {        
        $params = ["email" => $this->fields['email'] ];
        $record = current($this->queryBuilder->select($this->table, $params)); 
        
        if (!empty($record)){
            return true;
        }

        return false;
    }
    

    public function verifyPassword()
    {
        $params = ["email" => $this->fields['email'] ];
        $record = current($this->queryBuilder->select($this->table, $params)); 
        
        return password_verify($this->fields['password'], $record["password"]);
    }


    


    

}
<?php

declare(strict_types=1);

namespace App\Models;



use App\Models\ModelBase as Model;
use App\Models\Rol;
use App\helpers\CreateSecurePassword as Password;
use App\helpers\Create_JWT;



class User extends Model
{
    private string $JWT;
    /** Create Secure Password */

    /** Validate password function @return bool */
    public function __construct(
        ?int $id,
        string $created_at,
        ?string $updated_at,
        int $is_active,
        private string $email,
        private string $password,
        private string $username,
        private Rol $rol,

    ) {
        parent::__construct(
            id: $id,
            created_at: $created_at,
            updated_at: $updated_at,
            is_active: $is_active
        );
        $this->username = $username;
        $this->password = Password::crear($password);
        $this->email = $email;
        $this->rol = $rol;
    }


    /**Serializar la clase User devuelve un array con 
     * los atributos como claves
     */
    public function serializar(): array
    {
        $serializado = array_merge(get_object_vars($this), parent::serializar());
        $serializado['rol'] = $serializado['rol']->serializar();
        return $serializado;
    }
    /** Deserializa la clase User @return Self */
    static function deserializar(array $serializable): Self
    {


        return new Self(
            id: $serializable['id'],
            is_active: $serializable['is_active'],
            created_at: $serializable['created_at'],
            updated_at: $serializable['updated_at'],
            username: $serializable['username'],
            password: $serializable['password'],
            email: $serializable['email'],
            rol: Rol::deserializar($serializable['rol']),

        );
    }
    public function getUsername(): string
    {
        return $this->username;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function setPassword(string $new_pass): string
    {
        return $this->password = Password::crear($new_pass);
    }

    public function setRol(Rol $nuevoRol): void
    {
        $this->rol = $nuevoRol;
    }
    public function getRol(): Rol
    {
        return $this->rol;
    }

    public function crear_JWT(): string
    {
        return $this->JWT = Create_JWT::crear($this);
    }
    public function get_JWT(): string|false
    {
        if (isset($this->JWT)) {
            return $this->JWT;
        }
        return false;
    }


    public function setEmail($email)
    {
        $this->email = $email;
    }
}

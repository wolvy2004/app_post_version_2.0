<?php

declare(strict_types=1);

namespace App\Models;



use App\Models\ModelBase as Model;
use App\Models\Rol;
use App\helpers\CreateSecurePassword as Password;
use App\helpers\Create_JWT;



class User extends Model
{
    private  $JWT;
    private  $email;
    private  $password;
    private  $username;
    private Rol $rol;
    private $picture_profile;
    /** Create Secure Password */

    /** Validate password function @return bool */
    public function __construct(
        string $email,
        string $password,
        string $username,
        Rol $rol,
        string $picture_profile,
        int $id = 0,
        string $created_at = "now",
        string $updated_at = "",
        int $is_active = 1,

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
        $this->picture_profile = $picture_profile;
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
            id: (int)$serializable['id'],
            is_active: $serializable['is_active'] ?? 1,
            created_at: $serializable['created_at'],
            updated_at: $serializable['updated_at'] ?? "",
            username: $serializable['username'],
            password: $serializable['password'],
            email: $serializable['email'],
            rol: Rol::deserializar($serializable['rol']),
            picture_profile: $serializable['picture_profile']

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
    public function getPicture(): string
    {
        return $this->picture_profile;
    }
    public function setPicture($picture)
    {
        $this->picture_profile = $picture;
    }
}

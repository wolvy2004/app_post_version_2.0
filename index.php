<?php
class customException extends Exception
{
    public function errorMessage()
    {
        // Mensaje de error
        $errorMsg = $this->getMessage() . ' no es una dirección de email válida.';
        return $errorMsg;
    }
}
$email = "ejemplo@ejemplo.com";
try {
    try {
        // Comprobar la palabra ejemplo en el email:
        if (strpos($email, "ejemplo") !== FALSE) {
            // Lanzar una excepción si el email no es válido:
            throw new Exception($email);
        }
    } catch (Exception $e) {
        // Relanzar excepción:
        throw new customException($email);
    }
} catch (customException $e) {
    // Mostrar mensaje customizado:
    echo $e->errorMessage();
}

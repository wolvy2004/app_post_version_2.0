<?php

use App\config\Migrador;
use App\helpers\CreateSecurePassword as Password;

class AddUser extends Migrador
{
    /**
     * Do the migration
     */
    public function up()
    {

        $password = $this->createdPass();

        $sql = "INSERT INTO users (username, email, password, id_rol)
        VALUES
            ('jlopez', 'jlopez@gmail.com', '$password[1]', 1),
            ('mmartinez', 'mmartinez@hotmail.com', '$password[2]', 2),
            ('asanchez', 'asanchez@yahoo.com', '$password[3]', 1),
            ('dgonzalez', 'dgonzalez@outlook.com', '$password[4]', 1),
            ('mrodriguez', 'mrodriguez@aol.com', '$password[5]', 1),
            ('sfernandez', 'sfernandez@protonmail.com', '$password[6]', 2),
            ('alopez', 'alopez@icloud.com', '$password[7]', 1),
            ('perez', 'perez@rediffmail.com', '$password[8]', 1),
            ('rgarcia', 'rgarcia@live.com', '$password[9]', 1),
            ('mtorres', 'mtorres@ymail.com', '$password[10]', 2),
            ('rsanchez', 'rsanchez@inbox.com', '$password[11]', 1),
            ('jmartinez', 'jmartinez@zoho.com', '$password[12]', 1),
            ('ggonzalez', 'ggonzalez@yandex.com', '$password[13]', 1),
            ('ecastro', 'ecastro@mail.com', '$password[14]', 1),
            ('jramirez', 'jramirez@gmx.com', '$password[15]', 1),
            ('hernandez', 'hernandez@rocketmail.com', '$password[16]', 1),
            ('btorres', 'btorres@fastmail.com', '$password[17]', 1),
            ('flores', 'flores@tutanota.com', '$password[18]', 2),
            ('gutierrez', 'gutierrez@runbox.com', '$password[19]', 1),
            ('mendoza', 'mendoza@keemail.me', '$password[0]', 1),
             ('eguerra', 'eguerra@gmail.com', '$password[20]', 3);";
        $this->run($sql);
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $sql = "TRUNCATE TABLE users";
        $this->run($sql);
    }
    public function createdPass(): array
    {
        $password = [];
        for ($i = 0; $i < 21; $i++) {
            $password[$i] = Password::crear("password $i");
        }
        return $password; # code...
    }
}

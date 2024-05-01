# TRABAJO PRACTICO N° 5 📮
Vamos a comenzar a crear nuestra aplicacion de posteos , para lo cual necesitamos crear nuestros modelos, DAOs y controladores.
requerimos tener dos modelos: Post y Comment
## ANTES DE PONER MANOS A LA OBRA :construction_worker: 
Correr los comandos :
```
composer install
composer run migrate
```
Nuestro namespace es ahora **App//**
>recordar usarlo a la hora de crear todas las clases necesarias y al usarlas (***use***)

Abrir la terminal y copiar : ``mysql -uroot -p`` suponiendo que root sea un usuario valido, les va a pedir un password sino tiene presionen enter 
Copiar y correr el script dbsql.sql, esto les va a crear la base de datos pwd2024
renombrar el archivo ``.env-distr`` por ``.env`` y completar los datos con los propios de la base de datos

## MODELOS :file_folder:

>Todos los modelos deben extender de **ModelBase**

### Post
Son nuestras publicaciones, las mismas tienen: 
- id
- fecha de creacion (created_at)
- fecha de actualizacion (updated_at)
- si esta activo (is_active)
- cantidad de like (likes)
- cantidad de dislike (dislikes)
- usuario (user) que lo creo
- mensaje (post) 
- pueden tener una **imagen** (picture) (para el **upload** de las mismas en posteriores tps vamos a crear una clase especifica para ello).

### Comment 
Son los comentarios que podemos hacer en nuestros post y en los post de otros usuarios, estos poseen también:
- id
- fecha de creacion (created_at)
- fecha de actualizacion (updated_at)
- si esta activo (is_active)
- El texto **(comentario)** 
- usuario (user) que lo escribe y 
- el **post** al cual hace referencia.

### Desarrollo de los modelos
Crear los setters y getters a excepción del setter de id.
Para estas clases debemos redefinir los metodos **serializar** y **deserializar**.
Tenemos dos caminos para crear la lógica de estos métodos:
- la primera es como lo hicimos el año pasado donde cuando **serializamos** creamos a mano las claves y el valor.
Ejemplo:
```
return ['id'=> $this->id, 'created_at'=> $this->created_at ...]
```
- Pero ahora podemos utilizar unas funciones que son propias de PHP y nos ayuda a la hora de retornar o de usar atributos de un objeto;
```
return array_merge(get_object_vars($this), parent::serializar());
```
- El ``array_merge`` para el que no lo conozca, es una función que nos permite **fusionar** varios arrays, 
- El ``get_object_var()`` nos retorna un array con los atributos de nuestra clase con el nombre de los mismos como claves, 
- Con el  ``$this`` le estamos diciendo que nos retorne nuestros propios atributos, 
- Y el ``parent::serializar()`` nos devuelve los atributos del padre, tenemos que hacer esto porque si bien vamos a crear clases que extiendan de **ModelBase** sus atributos tanto como de la clase donde estemos son privados, y si solo devolvemos con ``get_object_vars($this)`` estamos obteniendo nuestros propios atributos.

> Tener cuidado con el metodo Deserializar
#### Este método va a recibir un array de parámetros para crear y retornar un nuevo objeto de la propia clase

```
static function deserializar(array params):Self{#<codigo>#}
```
Nuestras clases tienen la particularidad de recibir atributos que son objetos serializados los cuales debemos deserializar antes, por ejemplo **Post** recibe un objeto **User**, pero si intentamos crear un objeto **Post** el array que nos entregan por parametros no lo tiene, sino que en su lugar tiene un array con los datos del usuario. Entonces deberiamos antes convertilo en un objeto **User**
**Paso a iluminarlos: nuestro array de entrada es algo así**
***array de entrada***
```
['id'=>1, 'created_at'=>'now'... 'user'=>['id'=>1...'username'=>'pepito']]
```
***logica de creación del Post***
```
return new Post(
  id: $params['id'], created_at $params['created_at']... user:User::deserializar($params['user']...)
)
```
De esta manera al crear el nuevo **Post** no fallará porque el parámetro **user** ahora esta recibiendo un objeto **User**.
Para cualquier clase que tenga como atributos objetos es la misma lógica, debemos antes convertir los datos planos (array de string) en objetos.


**debemos crear además sus respectivos controladores**

## CONTROLADORES  :video_game:
>Todos los controladores deben extender de **ControllerBase**

Los mismos no poseen atributos propios sino que se basan en métodos que podemos llamar, son estaticos con lo cual no tenemos que instanciarlos.

- #### PostController:
- #### CommentController:
  
Tienen en común los métodos:
  - **crear(ISerializable $serializable): int**
  Recibe un objeto serializable y lo pasa como parámetro del metodo de la clase DAO correspondiente ``create`` y retorna un entero como respuesta
  - **listar(): ?array**
  Retorna un array con el todos los registros de la tabla, para ello usa el método correspondiente de la clase DAO ``read`` y retorna un entero como respuesta
  - **modificar(ISerializable $serializable): int**
  Recibe un objeto serializable y lo pasa como parametro al método de la clase DAO correspondiente ``update`` y retorna un entero como respuesta
  - **borrar(int $id): int**
  Recibe un entero y lo pasa como parametro al método de la clase DAO correspondiente 
  ``destroy`` y retorna un entero como respuesta
  - **buscarUno(string|int $id): false|array**
  Retorna un registro de acuerdo al entero que recibe, este mismo es pasado como parametros al método de la clase DAO correspondiente ``findOne``

## DAOs :floppy_disk:
>Todos los DAOs deben extender de **DAOBase**

Los mismos no poseen atributos propios sino que se basan en métodos que podemos llamar, son estáticos con lo cual no tenemos que instanciarlos.

- #### PostDAO:
- #### CommentDAO:
  
Tienen en común los métodos
   - ``**create(array $params): int:**``
    Crea un nuevo registro se le debe pasar los parámetros básicos necesarios y depende de cada clase
   - `**read(): ?array**`
    Retorna una lista de registros (en formato arrays y mediante la consulta select)
   - ``**destroy(int $id): int**``
   Elimina un registro de acuerdo al id que le pasemos
   - ``**update(array $register): int**``
   modifica y actualiza un registro
   - ``**findOne(string|int $id): ?array**``
   Encuentra un registro especificado por el id, que puede ser un cadena o un entero
  
 ### Sobre las clases Controladores
los controladores deben serializar los objetos que reciben, en el caso del update primero deben modificar el objeto de acuerdo a los parametros que recibe por ejemplo:
en el **Post** podemos modificar 
- el post (mensaje)
- los likes (+/-)
- los dislikes(+/-)
- picture (imagen)
pero no podremos modificar nada más, el usuario y el id no pueden ser cambiados
en **Comment** modificaremos:
- comentario (mensaje)
recuerden crear los métodos (en los modelos) para cada uno de estas modificaciones (los infames setters)
Tener precaucion en los setters de likes y dislike deben sumar o restar y no cambiar el valor unicamente 
### Sobre las clases Modelos
Recuerden nombrar correctamente a los atributos tal como se piden en el apartado de creación de modelos.
### Sobre las clases DAOs
Las clases DAO tiene sentencias SQL (Repasen un poco de CBD)
por ejemplo para buscar un registro:

```
$sql = "SELECT * FROM users WHERE username = :username;";
$params = ['username' => $parametros['username']];
return DBConect::read(sql:$sql, params:$params);
```
- En este ejemplo creamos nuestra consulta y nuestros parametros son los que recibe el metodo, en este caso recibe un objeto el cual debemos serializar y guardar en una variable $parametros 
- El **:username** nos permite reemplazar la variable por datos personalizados que vamos a enviar en la consulta mediante un array, donde las claves tienen que tener el mismo nombre
- Llamamos al método estatico **read** de la clase **DBConect**
- Retornamos nuestro resultado en una variable, el retorno en este ejemplo es un array de un elemento (**indice 0**), para acceder al mismo debemos anteponer el [0]

 ### Metodologia para aprobar el Trabajo Práctico
  Para poder aprobar este trabajo práctico deben correr los test mediante el script `composer run test`  o desde el icono del bichito con el play de vsc (php debug)
  ### Conceptos que vemos en este TP
  * Capas de Modelo y de Controlador del patrón MVC
  * Patrón de diseño **DAO** (Data Access Object)
  * Comunicación entre el backend y la base de datos mediente **PDO** (PHP Data Object)
  * Utilización de los namespaces 
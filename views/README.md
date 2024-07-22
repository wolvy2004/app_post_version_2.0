
# TP N°7

## Creación de un CRUD en VUE.js

### Pasos previos

Ejecutar los comandos

``` cmd
composer install
npm install
```

Luego correr el comando

```cmd
npm run dev
```

Este ultimo comando habilita el servidor de ```php``` y el de ```node.js``` con eso podremos trabajar y ver los cambios que hagamos en el navegador, ya tendremos ademas el backend corriendo para testear la comunicación.

Para este TP vamos a crear un **CRUD** (Create, Read, Update and Delete) para nuestros POSTS.

### Nos toca crear el servicio

En la carpeta ```Service``` crear un archivo llamado ```PostService.ts```, el mismo contendra una clase homonima que servira para realizar las consultas al backend utilizando los endpoints o rutas predefinidas por nosotros en nuestro backend, además de tres atributos, ``posts`` (arreglo de todos los post),``post``(un post en particular) y ``posts_by_user`` (arreglo de todos los posts de un usuario)

- GET ``"/apiv1/posts"`` -- **Listado de todos los posts**
- GET ``"/apiv1/posts/{id}"`` -- **listado de un post en particular.**
- GET ``"/apiv1/posts/user/{id}"`` -- **listado de todos los post de un usuario en particular**
- POST "/apiv1/posts" -- creación de un nuevo post
- PUT ``"/apiv1/posts/{id}"`` -- **modificación de un post existente**
- DELETE ``"/apiv1/posts/{id}"`` -- eliminar un post existente
- DELETE ``"/apiv1/posts/user/{id}"`` -- eliminar todos los post de un usuario.

#### Para cada ruta crearemos un metodo

- ``getPosts():Array<IPost>`` retorna los posts existentes
luego de haber ejecutado el metodo ``fetchAll():Promise<void>``
- ``getPost():IPost`` retorna un post en particular luego de haber ejecutado el metodo ``fetchById(id_post):Promise<void>``
- ``getPostbyUser():Array<IPost>`` retorna los post de un usuario en particular luego de haber ejecutado el metodo ``fetchByUser(id_user):Promise<void>``
- ``deletePost(id_post)`` elimina un post en particular
- ``deletePostByUser(id_user)`` elimina todos los posts de un usuario en particular
- ``updatePost(id_post, post)`` modifica un Post existente
- ``createPost(post)`` crea un nuevo Post

### Creando los componentes

- Crear una carpeta nueva en ``components`` llamada ``Post``.
En dicha carpeta crear los siguientes componentes:
- ``PostDetailtComponent.vue`` que tendrá el detalle del Post, todos los datos que son propios incluyendo los mensajes (``messages``).
- ``PostItem.vue`` que sera el encargado de mostrar los datos del post en la vista ademas de que tiene que tener los botones para el update y el delete del post. (la funcion delete debe llamar al metodo ``deletePost()`` de la clase ``PostService``)
- ``PostCreateComponent.vue``
  Este sera el formulario para agregar un nuevo Post, tendra por consiguiente que tomar en sus inputs ``titulo`` o ``post``, ``usuario`` este dato tiene que tomarlo del store ``Auth`` ya que solo podrá escribir un usuario registrado y ``picture``. los demas datos de un post son agregados por defecto cuando se crea
- ``PostUpdateComponent.vue``
  este componente debe tomar un post y modificarlo. recordar que solo se pude modificar el ``titulo`` o la ``imagen``.

En la Carpeta ``Layouts`` crear un nuevo componente llamado ``PostListLayout.vue``. el cual se encarga de mostrar los Post en forma de lista. Este componente importa ``PostItems`` y lo usa para renderizar en forma iterativa los posts.

### Creando las Vistas

Crear componente en la carpeta ```views``` llamado ``PostsView.vue`` el cual importará el ``PostListLayout`` y sera el encargado de hacer las llamadas a la api para mostrar los post, con lo cual importara el PostService el cual guardara en una constante que le pasará al componente PostListLayout como ``prop``.

### Creando las rutas

Crearemos un archivo de rutas para los posts (```PostRoutes.ts```) que deben contener las rutas para crear, modificar, visualizar y listar los mismos. no tendremos una ruta para eliminarlos.
estas rutas deben agregarse a las rutas base que se encuentran en el archivo ```index.js``` de la carpeta ```routes```.

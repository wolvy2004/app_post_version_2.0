const url = "http://localhost:8080/apiv1/users";

const id = 1;

axios // Todos los registros
  .get(url)
  .then((response) => {
    this.users = response.data;
  })
  .catch((error) => console.log(error)); // conseguir datos de la api

axios // un registro en particular
  .get(url + "/" + id)
  .then((response) => {
    this.users = response.data;
  })
  .catch((error) => console.log(error));

axios // enviar datos a la api
  .post(url, user)
  .then((res) => {
    return { status: res.data.status, message: res.data.message };
  })
  .catch((e) => {
    console.log(e);
  });

axios // modificar datos
  .put(url + "/" + id, user)
  .then((res) => {
    return { status: res.data.status, message: res.data.message };
  })
  .catch((e) => {
    console.log(e);
  });

axios // eliminar datos
  .delete(url + "/" + id)
  .then((res) => {
    return { status: res.data.status, message: res.data.message };
  })
  .catch((e) => {
    console.log(e);
  });

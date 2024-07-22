<template>
  <main>
    <h1>Registro de Usuario</h1>
    <form @submit.prevent>
      <div>
        <v-text-field
          prepend-inner-icon="mdi-account"
          name="name"
          label="nombre de usuario"
          :rules="UsernameRules"
          required
          v-model="username"
        ></v-text-field>
        <v-text-field
          prepend-inner-icon="mdi-email"
          name="email"
          label="email"
          :rules="EmailRules"
          v-model="email"
        ></v-text-field>
        <v-text-field
          prepend-inner-icon="mdi-lock"
          name="password"
          type="password"
          label="password"
          :rules="[(v:string) => !!v || 'password requerido']"
          v-model="password"
        ></v-text-field>
        <v-file-input
          :rules="[(v:string) => !!v || 'imagen requerido']"
          label="File input"
          @change="upload_file"
          name="upload_file"
        ></v-file-input>
      </div>
      <picture class="position-relative">
        <img class="preview position-relative" :src="preview" alt="" />
        <v-btn
          flat
          color="grey-lighten-2"
          size="x-small"
          v-if="preview != preview_img"
          @click="removeImage"
          class="position-absolute top-0 right-0 mt-2 mr-2"
          icon="mdi-close"
        ></v-btn>
      </picture>
      <div>
        <v-btn prepend-icon="mdi-send" @click.prevent="create" color="success">
          enviar</v-btn
        >
      </div>
    </form>
  </main>
</template>

<script setup lang="ts">
import { ref } from "vue";
import UserService from "../services/UserService.ts";
import { useRouter } from "vue-router";

const service = new UserService();
const router = useRouter();
const exist_username = ref<boolean>(false);
const exist_email = ref<boolean>(false);

const preview_img = "../imgs/preview.jpg";
const username = ref<string>("");
const password = ref<string>("");
const email = ref<string>("");
const EmailRules = [
  (value: string) => !!value || "email es requerido",
  async () => !(await checkEmail()) || "el email existe",
  (value: string) =>
    (value && value.length >= 6) ||
    "el username tiene que tener mas de 6 caracteres",
  (value: string) =>
    (!!value && /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/.test(value)) ||
    "el email debe tener un formato valido",
];
const UsernameRules = [
  (value: string) => !!value || "username es requerido",
  async () => !(await checkUsername()) || "el usuario existe",
  (value: string) =>
    (value && value.length >= 6) ||
    "el username tiene que tener mas de 6 caracteres",
];

let file = ref<File | null>(null);
const preview = ref<string>(preview_img);
const upload_file = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const selectElement = target.files ? target.files[0] : null;

  if (selectElement) {
    const allowedTypes = [
      "image/jpeg",
      "image/png",
      "image/gif",
      "image/bmp",
      "image/webp",
      "image/tiff",
    ];
    if (!allowedTypes.includes(selectElement.type)) {
      alert("tipo no permitido");
      file.value = null;
    } else {
      file.value = selectElement;
      preview.value = URL.createObjectURL(selectElement);
    }
  }
};
const removeImage = () => {
  if (preview.value) {
    preview.value = preview_img;
  }
};
async function checkUsername() {
  if (username.value.length >= 6) {
    return await service.checkUsername(username.value.toLowerCase());
  }
  return false;
}
async function checkEmail() {
  if (username.value.length >= 6) {
    console.log(await service.checkEmail(email.value.toLowerCase()));
    return await service.checkEmail(email.value.toLowerCase());
  }
  return false;
}
const create = async () => {
  if (
    username.value === "" ||
    password.value === "" ||
    email.value === "" ||
    file.value === null ||
    exist_email.value === true ||
    exist_username.value === true
  ) {
    alert(
      "debe rellenar todos los campos y el username y email no pueden ser ya utilizados"
    );
  } else {
    const newUser = {
      username: username.value,
      password: password.value,
      email: email.value,
      rol: null, // rol predefinido
      pix_profile: file.value,
    };
    const exito = await service.createUser(newUser);
    if (exito.status === 201) {
      alert(exito.message);

      router.go(-1);
      //router.push({ name: "LoginPage " });
    } else {
      alert(exito.message);
    }
  }
};
</script>

<style scoped>
main {
  display: flex;
  justify-content: center;
  flex-direction: column;
  justify-content: start;
  align-items: center;
  margin-top: 100px;
}
picture {
  width: 400px;
  height: 400px;
  object-fit: cover;
  border: 2px solid black;
}
span {
  position: absolute;
  right: 5px;
  top: 5px;
  color: red;
}
h1 {
  font-size: 1.5em;
  margin: 1.5em;
}
form {
  border: 1px solid #4e4d4d;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px;
  width: 900px;
  min-width: 400px;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
  padding: 1rem;
}
.content_input,
.select_file {
  position: relative;
  width: 100%;
  margin: 1em;
  padding: 0.2em;
  height: 45px;
  background-color: #e9f8ff;
  border-radius: 10px;
  color: black;
}
input::placeholder {
  position: absolute;
  color: #9a9a9a;
  top: 10px;
}
.content_input label,
.select_file label {
  position: absolute;
  top: 5px;
  left: 10px;
}
.select_file::before {
  position: absolute;
  content: "seleccionar foto";
  padding-left: 45px;
  color: #9a9a9a;
  top: 8px;
}

input[type="file"],
input {
  outline: none;
  padding-left: 45px;
  width: 100%;
  height: 35px;
  color: black;
}
input[type="file"] {
  opacity: 0;
  display: inline-block;
  z-index: 5;
}
button {
  width: 100%;
  height: 50px;
  transition: 0.5s linear;
}
button:hover {
  background-color: #5061ff;
}

.preview {
  width: 100%;
  height: 100%;

  object-fit: cover;
}
</style>

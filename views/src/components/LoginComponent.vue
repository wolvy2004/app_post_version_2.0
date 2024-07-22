<template>
  <main>
    <form action="">
      <h2>Acceso de usuarios <v-icon icon="mdi-account-multiple"></v-icon></h2>

      <v-text-field
        label="Nombre de usuario"
        v-model="username"
        prepend-inner-icon="mdi-account"
      ></v-text-field>
      <v-text-field
        :type="typePassword"
        label="password"
        v-model="password"
        prepend-inner-icon="mdi-lock"
        :color="colorPassword"
        :append-inner-icon="icon_append_password"
        @click:append-inner="showPassword"
      ></v-text-field>

      <v-btn
        flat
        @click.prevent="login"
        prepend-icon="mdi-login"
        color="success"
        >Ingresar</v-btn
      >
    </form>
    <v-snackbar v-model="snackbar" close-delay="2000" color="red">
      <v-icon>mdi-alert-circle</v-icon>

      {{ text }}

      <template v-slot:actions>
        <v-btn
          icon="mdi-close"
          color="white"
          variant="text"
          @click="snackbar = false"
          location="top"
        />
      </template>
    </v-snackbar>
  </main>
</template>

<script setup lang="ts">
import { ref, Ref } from "vue";
import { useRouter } from "vue-router";
import UserService from "../services/UserService";
const router = useRouter();
const services = new UserService();
const username: Ref<string> = ref("");
const password: Ref<string> = ref("");
const auth = ref<{ code: number; message: string }>();

const typePassword = ref<string>("password");
const icon_append_password = ref<string>("mdi-eye");
const swichtPass = ref<Boolean>(true);
const colorPassword = ref<String>("blue");
const snackbar = ref<Boolean>(false);
const text = ref<string>("");
const showPassword = () => {
  if (swichtPass.value) {
    swichtPass.value = false;
    typePassword.value = "text";
    colorPassword.value = "green";
    icon_append_password.value = "mdi-eye-off";
  } else {
    typePassword.value = "password";
    colorPassword.value = "blue";
    icon_append_password.value = "mdi-eye";
    swichtPass.value = true;
  }
};
const login = async () => {
  if (username.value != "" && password.value != "") {
    auth.value = await services.login(username.value, password.value);
    console.log(auth.value);
    switch (auth.value.code) {
      case 403:
        snackbar.value = true;
        text.value = "Error: Password incorrecto";
        break;
      case 404:
        snackbar.value = true;
        text.value = "Error: Usuario incorrecto";
        break;
      case 200:
        router.push("/");
        break;
      default:
        break;
    }
  } else {
    snackbar.value = true;
    text.value = "Error: los campos deben estar completos";
  }
};
</script>

<style scoped>
main {
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
}
form {
  display: flex;
  flex-direction: column;
  justify-content: center;

  width: 400px;
  padding-top: 2em;
  border-radius: 15px;

  box-shadow: 00px 0px 25px rgba(1, 4, 1, 0.2);
}
h2 {
  text-align: center;
  margin-bottom: 1em;
  background-color: rgb(34, 95, 201);
  width: 400px;
  padding: 0.5em;
  color: azure;
  text-transform: uppercase;
}
.input-wrapper {
  display: flex;
  justify-content: center;
  position: relative;
  padding: 1em;
  width: 100%;
  margin: 1.2em 1em;
}
label {
  position: absolute;
  top: -35px;
  left: 12px;
}
button {
  width: 85%;
  text-transform: uppercase;
  margin: 1em;
}
button:hover {
  background-color: #1778df;
}
input,
label {
  height: 40px;
  font-size: 1.2em;
  padding: 0.5em;
  width: 100%;
}
input {
  background-color: aliceblue;
  color: black;
}
</style>

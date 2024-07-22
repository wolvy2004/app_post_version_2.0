<template>
  <ul>
    <li v-for="(link, id) in links">
      <router-link :key="id" :to="{ name: link.to }"
        ><v-icon :icon="link.icon" />{{ link.text_link }}
      </router-link>
    </li>
  </ul>
</template>

<script setup lang="ts">
interface Link {
  text_link: string;
  to: string;
  reqAuth?: Boolean;
  rol: string;
  icon: string;
}
import { ref } from "vue";
import useAuthStore from "../store/auth";
const store = useAuthStore();
const enlaces: Array<Link> = [
  { text_link: "Home", to: "Home", rol: "", icon: "mdi-home" },
  {
    text_link: "Usuarios",
    to: "Users",
    reqAuth: true,
    rol: "admin",
    icon: "mdi-account-multiple",
  },
  { text_link: "Login", to: "LoginPage", rol: "", icon: "mdi-login" },
  { text_link: "Registro", to: "Register", rol: "", icon: "mdi-account-plus" },
  { text_link: "Logout", to: "Logout", rol: "", icon: "mdi-logout" },
];
const links = ref(enlaces);
</script>

<style scoped>
ul {
  list-style: none;
  display: flex;
  justify-content: center;
  align-items: center;
}
ul li a {
  text-decoration: none;
  color: white;
  margin: 1em;
  padding: 0.5em 1em;
  border-radius: 10px;
}
i {
  margin: 1em 0.5em;
}
a.router-link-active {
  background-color: rgb(17, 82, 157);
}
</style>

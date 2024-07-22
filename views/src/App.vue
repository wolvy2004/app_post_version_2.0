<template>
  <nav>
    <ul>
      <li v-if="store.getAuthorized">
        <router-link :to="{ name: 'Home' }">Home</router-link>
      </li>
      <li>
        <router-link :to="{ name: 'Posts' }">Posts</router-link>
      </li>

      <li v-if="!store.getAuthorized">
        <router-link :to="{ name: 'LoginPage' }">Login</router-link>
      </li>

      <li v-if="!store.getAuthorized">
        <router-link :to="{ name: 'registro' }">Registrarse</router-link>
      </li>

      <div class="is_auth" v-if="store.rol === 'admin'">
        <li><router-link :to="{ name: 'users' }">Usuarios</router-link></li>
        <li>
          <router-link :to="{ name: 'Dashboard' }">Dashboard</router-link>
        </li>
      </div>

      <li v-if="store.getAuthorized">
        <span class="text-center text-amber-accent-1"
          >Bienvenido/a
          <strong class="text-white">{{ store.getUsername }} </strong></span
        >
        <v-avatar size="48" color="red">
          <img
            width="48"
            :src="'http://localhost:8080/uploads/' + store.getPictureProfile"
            alt="alt"
          />
        </v-avatar>
      </li>
      <li v-if="store.getAuthorized">
        <v-btn flat class="ml-5" @click="logout" prepend-icon="mdi-logout"
          >salir</v-btn
        >
      </li>
    </ul>
  </nav>
  <main>
    <router-view v-slot="{ Component }">
      <transition name="fade">
        <component :is="Component" />
      </transition>
    </router-view>
  </main>
</template>

<script setup lang="ts">
import { useAuthStore } from "./store/auth";
import { useRouter } from "vue-router";
const router = useRouter();
const store = useAuthStore();
const logout = () => {
  store.logout();
  router.push("/login");
};
</script>

<style scoped>
nav {
  position: absolute;
  width: 100%;
  top: 0;
  left: 0;
  line-height: 70px;
  height: 75px;
  background-color: #007acc;
  display: flex;
  justify-content: center;
  align-items: center;
}

nav a,
div a,
nav div span {
  color: #ffffff;
  cursor: pointer;
}
a {
  padding: 1em;
}
ul {
  display: flex;
  list-style: none;
}
.router-link-active,
.router-link-exact-active {
  color: #229ff2;
  cursor: pointer;

  border-radius: 10px;
  background-color: black;
}
.fade-enter-active {
  transition: all 3s ease-out;
}

.fade-leave-active {
  transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
main {
  width: 100%;
  height: calc(100vh - 100px);
}
.is_auth {
  display: flex;
}
</style>

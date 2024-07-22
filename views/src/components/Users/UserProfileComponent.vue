<template>
  <main>
    <v-btn @click="goTo" rounded variant="text">
      <v-icon icon="mdi-keyboard-backspace" /> volver</v-btn
    >
    <h1 class="ma-5 align-baseline pa-10">Perfil de usuario</h1>

    <article>
      <div class="image_profile">
        <picture>
          <img
            :src="'http://localhost:8080/uploads/' + user.picture_profile"
            alt=""
          />
        </picture>
      </div>
      <div class="info">
        <p class="border-b-sm border-background">
          <v-icon>mdi-account</v-icon> Nombre de usuario
        </p>

        <h1 class="pa-1">
          {{ user.username }}
        </h1>
        <p class="rol me-5 my-5">
          <v-icon icon="mdi-account-wrench" />Rol
          <span> {{ user.rol?.descripcion }}</span>
        </p>
        <p class="email my-5"><v-icon icon="mdi-email" />{{ user.email }}</p>

        <p class="created my-5">
          <v-icon icon="mdi-calendar" /> <span>Se registro</span>
          {{ dayjs(user.created_at).fromNow() }}
        </p>
        <v-spacer />
        <div>
          <v-btn rounded class="text-h6" prepend-icon="mdi-post" variant="text"
            >5</v-btn
          >
          <v-btn class="text-h6" prepend-icon="mdi-comment" variant="text"
            >5</v-btn
          >
        </div>
      </div>
    </article>
  </main>
</template>

<script setup lang="ts">
// componente para tiempo humanizado
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import duration from "dayjs/plugin/duration";
import es from "dayjs/locale/es";
dayjs.locale(es);
dayjs.extend(duration);
dayjs.extend(relativeTime);
//-------

import { onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import UserService from "../../services/UserService";

const service = new UserService();
const user = service.getUser();

onMounted(async () => {
  const route = useRoute();
  var id = route.params.id;
  await service.fetch_Id(id);
});

const router = useRouter();
function goTo() {
  // router.push("/usuarios");
  router.go(-1);
}
</script>

<style scoped>
main {
  width: 100%;
  margin-top: 150px;
  display: flex;
  justify-content: start;
  align-items: center;
  flex-direction: column;
}

article {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 50px;
  justify-content: center;
  align-items: center;
  height: 50%;
}

h1 {
  color: rgb(36, 110, 208);
  cursor: pointer;
  margin: 0;
}
.created {
  font-size: 1em;
}
.rol span {
  color: rgb(36, 110, 208);
  font-weight: 900;
  font-size: 1.2em;
  margin-left: 0.5em;
  background-color: azure;
  padding: 0.2em 0.5em;
  text-transform: uppercase;
  border-radius: 10px;
}
picture img {
  width: 250px;
  height: 250px;
  border-radius: 50%;
  object-fit: cover;
}
.image_profile {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.email {
  font-size: 1.5em;
}
span {
  font-weight: 600;
}
</style>

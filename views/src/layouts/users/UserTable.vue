<template>
  <main>
    <div v-if="cargando" class="loading">
      <div class="loader"><p>Cargando</p></div>
    </div>
    <article v-else>
      <ul>
        <RouterLink
          :to="{ name: 'UserProfile', params: { id: user.id } }"
          v-for="user in users"
          :key="user.id"
        >
          <li>
            <p>{{ user.username }}</p>
            <div class="info-user">
              <p class="email">{{ user.email }}</p>
              <span class="created">{{ user.created_at }}</span>
              <span class="updated">{{ user.updated_at }}</span>
              <p>{{ user.rol?.descripcion }}</p>
            </div>
          </li>
        </RouterLink>
      </ul>
    </article>
  </main>
</template>

<script setup lang="ts">
import { onMounted, ref, Ref } from "vue";
import UserService from "../../services/UserService";

const service = new UserService();
const users = service.getUsers();
const cargando: Ref<Boolean> = ref(true);

onMounted(async () => {
  await service.fetchAll();
  if (service) {
    cargando.value = false;
  }
});
</script>

<style scoped>
.loading {
  width: 100%;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
}
article {
  justify-content: start;
}
ul {
  list-style: none;
  margin: 0 auto;
}
/* HTML: <div class="loader"></div> */
.loader {
  width: 40%;
  height: 25px;
  background: linear-gradient(to left, #1055d5, #0d88fb) 0/0% no-repeat #413f3f;
  animation: l1 1500ms infinite linear;
  border-radius: 10px;
  display: flex;
  justify-content: center;
}
.loader p {
  margin-top: 25px;
}

@keyframes l1 {
  100% {
    background-size: 100%;
  }
}
li {
  width: 100%;
  display: flex;
  margin-bottom: 0.5em;
  justify-content: space-between;
  align-items: center;

  padding: 0em 3em;
  transition: all 0.5s ease-in;
}
li p {
  transition: all 0.5s ease-in;
}
li:hover > p {
  color: #00f2ff;
}
li:nth-child(even) {
  background-color: #292929;
}
li:hover {
  background-color: #3d3d3d;
}
li a {
  font-size: 1.2em;
}
.info-user {
  border-left: 1px solid #6d6c6c;
  padding-left: 3em;
  width: 70%;
  display: flex;
  align-items: center;
  justify-content: space-around;
}
.info-user p {
  display: inline-block;
  color: #858484;
}
.info-user span {
  color: #656464;
  font-size: 0.5em;
  margin-left: 3em;
}
</style>

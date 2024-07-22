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
            <h1>{{ user.username }}</h1>
            <div class="info-user">
              <p class="email">{{ user.email }}</p>
              <span class="created">{{ user.created_at }}</span>
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
main {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: start;
  align-items: center;
}
.loading {
  width: 100%;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
}
article {
  justify-content: center;
}
ul {
  list-style: none;
  display: grid;
  gap: 1em;
  grid-template-columns: repeat(4, minmax(300px, 1fr));
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
  display: flex;
  flex-direction: column;
  padding: 0.5em;
  justify-content: space-between;
  align-items: center;
  border: 1px solid #3d3d3d;
  transition: all 0.5s ease-in;
  border-radius: 15px;
}
li h1 {
  transition: all 0.5s ease-in;
  font-size: 2em;
  text-align: center;
}
li:hover > h1 {
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
  width: 100%;
  text-align: center;
}
.info-user p {
  color: #858484;
  font-size: 0.9em;
  height: 1em;
}
.info-user span {
  color: #656464;
  height: 0.7em;
  font-size: 0.5em;
}
</style>

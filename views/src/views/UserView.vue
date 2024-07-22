<template>
  <main>
    <h3>Listado de usuarios</h3>
    <v-container class="d-flex ga-2">
      <v-text-field
        label="buscar usuario"
        v-model="searchUser"
        prepend-inner-icon="mdi-account-search"
        height="50px"
        width="500px"
        class="mx-auto mt-10"
      />
      <v-select
        :items="roles"
        item-title="descripcion"
        v-model="SelectRol"
        label="Seleccione el rol"
        height="50px"
        width="500px"
        class="mx-auto mt-10"
      ></v-select>
    </v-container>

    <nav>
      <a @click="current_link = 'Lista'"><icon-list /></a>
      <a @click="current_link = 'Cards'"> <icon-card /></a>
      <a @click="current_link = 'Table'"><icon-table /></a>
    </nav>

    <component :users="selectUsers" :is="links[current_link]" />
  </main>
</template>

<script setup lang="ts">
import { ref, defineAsyncComponent, onMounted, computed } from "vue";
import IconList from "../components/assets/IconList.vue";
import IconCard from "../components/assets/IconCard.vue";
import IconTable from "../components/assets/IconTable.vue";
import UserService from "../services/UserService";

const roles = [
  { id: 1, descripcion: "admin" },
  { id: 2, descripcion: "super admin" },
  { id: 3, descripcion: "public" },
  { descripcion: "todos" },
];
const SelectRol = ref<String>("");
const service = new UserService();
const users = service.getUsers();
const searchUser = ref<string>("");
onMounted(async () => {
  await service.fetchAll();
});
const selectUsers = computed(() => {
  return users.value.filter((user) => {
    const usersMatch = user.username
      ?.toLowerCase()
      .includes(searchUser.value.toLowerCase());
    const userRolMatch = SelectRol.value
      ? user.rol?.descripcion === SelectRol.value
      : true;
    const usersMatchEmail = user.email
      ?.toLowerCase()
      .includes(searchUser.value.toLowerCase());
    return usersMatch || (usersMatchEmail && userRolMatch);
  });
});

type LinkKeys = "Lista" | "Cards" | "Table";

const current_link = ref<LinkKeys>("Lista");

const links: { [key in LinkKeys]: ReturnType<typeof defineAsyncComponent> } = {
  Lista: defineAsyncComponent(() => import("../layouts/users/UserList.vue")),
  Cards: defineAsyncComponent(() => import("../layouts/users/UserCards.vue")),
  Table: defineAsyncComponent(() => import("../layouts/users/UserTable.vue")),
};
</script>

<style scoped>
main {
  text-align: center;
  margin-left: 50%;
  transform: translateX(-50%);
}

ul {
  display: flex;
  list-style: none;
}
ul li a {
  background: #000;
  padding: 0.5em 1em;
  margin: 0.5em;
}
</style>

<template>
  <ul>
    <li>
      <img
        :src="'http://localhost:8080/uploads/' + user.picture_profile"
        alt=""
      />
      <RouterLink :to="{ name: 'UserProfile', params: { id: user.id } }">
        <p>{{ user.username }}</p></RouterLink
      >
      <div class="info-user">
        <p class="email"><v-icon icon="mdi-email"></v-icon>{{ user.email }}</p>

        <p class="rol">{{ user.rol?.descripcion }}</p>
      </div>
      <v-menu open-on-hover transition="slide-y-transition"
        ><template v-slot:activator="{ props }">
          <v-btn
            color="primary"
            v-bind="props"
            variant="text"
            icon="mdi-dots-vertical"
          >
          </v-btn>
        </template>
        <v-list opacity="1">
          <v-list-item v-for="(item, id) in menu" :key="id" :color="item.color">
            <v-btn
              flat
              variant="text"
              :icon="item.icon"
              :color="item.color"
              @click="$emit(item.action, user.id)"
            />
          </v-list-item>
        </v-list>
      </v-menu>
    </li>
  </ul>
</template>

<script lang="ts" setup>
import type IUser from "../../Interfaces/IUser";

const menu = [
  {
    icon: "mdi-trash-can-outline",
    text: "Eliminar",
    color: "error",
    action: "deleteUser",
  },
  {
    icon: "mdi-pencil-outline",
    text: "Modificar",
    color: "success",
    action: "updateUser",
  },
  {
    icon: "mdi-eye-outline",
    text: "Detalle",
    color: "primary",
    action: "detailUser",
  },
];
defineProps<{ user: IUser }>();
</script>

<style scoped>
ul {
  list-style: none;
  display: flex;
  align-items: center;
  flex-direction: column;
}
li {
  width: 80%;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  justify-content: center;
  align-items: center;
  padding: 0.5em 3em;
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
  width: 700px;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
}
a {
  width: 300px;
}
.rol {
  width: 200px;
  background-color: #0d88fb;
}
.info-user {
  color: #ffffff;
}

img {
  width: 50px;
  height: 50px;
  object-fit: cover;
  border-radius: 50%;
}
i {
  margin: 0.2em;
  width: 0.2em;
  height: 0.2em;
}
input {
  width: 600px;
}
.email {
  display: flex;
  align-items: center;
  gap: 1em;
}
</style>

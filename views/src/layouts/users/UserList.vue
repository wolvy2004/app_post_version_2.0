<template>
  <main>
    <div v-if="cargando" class="loading">
      <div class="loader"><p>Cargando</p></div>
    </div>
    <article v-else>
      <UserItem
        @deleteUser="deleteItem"
        @updateUser="updateUser"
        @detailUser="detailUser"
        v-for="user in users"
        :user="user"
      ></UserItem>
    </article>
  </main>
</template>

<script setup lang="ts">
import { onMounted, ref, Ref } from "vue";
import type IUser from "../../Interfaces/IUser";
import UserItem from "../../components/Users/UserItemListComponent.vue";

const props = defineProps({ users: Array<IUser> });

onMounted(() => {
  if (props) {
    cargando.value = false;
  }
});
const emit = defineEmits(["delete-user", "update-user", "detail-user"]);
const deleteItem = (id: number) => {
  emit("delete-user", id);
};
const updateUser = (id: number) => {
  emit("update-user", id);
};
const detailUser = (id: number) => {
  emit("detail-user", id);
};
const cargando: Ref<Boolean> = ref(true);
</script>

<style scoped>
.loading {
  width: 100%;
  color: #ffffff;
  display: flex;
  justify-content: center;
  align-items: center;
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
article {
  margin-top: -150px;
}
</style>

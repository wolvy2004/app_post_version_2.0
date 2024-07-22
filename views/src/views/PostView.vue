<template>
  <v-container class="d-flex justify-center align-center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="800px"
      transition="dialog-transition"
    >
      <template v-slot:activator="{ props: activatorProps }">
        <v-btn
          v-bind="activatorProps"
          v-if="store.getAuthorized"
          size="x-large"
          prepend-icon="mdi-pencil"
          color="blue"
          @click="current_component = 'create'"
          >escribe una idea o un mensaje...</v-btn
        >
      </template>
      <v-card>
        <v-btn
          width="10px"
          class="right-0 position-absolute"
          variant="flat"
          tile
          color="error"
          prepend-icon="mdi-close"
          @click="dialog = false"
        ></v-btn>

        <component
          :is="links[current_component]"
          @dialog="cerrarVentana"
          :id="id"
          :Posts="postlist"
        />
      </v-card>
    </v-dialog>
  </v-container>
  <PostCardLayout :Posts="postlist" @edit_post="editar_post" />
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import PostCardLayout from "../layouts/posts/PostCardsLayout.vue";
import PostService from "../services/PostService";
import { useAuthStore } from "../store/auth";
import create from "../components/Posts/PostCreateComponent.vue";
import edit from "../components/Posts/PostUpdateComponent.vue";
const services = new PostService();
const postlist = services.getPosts();
const store = useAuthStore();
const dialog = ref(false);
const id = ref(0);

const links = { edit, create };
type Link = "edit" | "create";
let current_component = ref<Link>("edit");
onMounted(async () => {
  await services.fetchAll();
});
const cerrarVentana = async (cerrar: boolean) => {
  dialog.value = cerrar;
  await services.fetchAll();
};
const editar_post = (id_post: number) => {
  current_component.value = "edit";
  id.value = id_post;
  dialog.value = true;
};
</script>

<style scoped></style>

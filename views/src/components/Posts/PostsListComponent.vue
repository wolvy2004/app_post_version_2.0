<template>
  <v-container class="d-flex justify-center align-center">
    <v-btn
      v-if="store.getAuthorized"
      size="x-large"
      prepend-icon="mdi-pencil"
      color="blue"
      >escribe una idea o un mensaje...</v-btn
    >
  </v-container>

  <PostCardLayout :Posts="postlist" />
</template>

<script setup lang="ts">
import { onMounted } from "vue";
import PostCardLayout from "../../layouts/posts/PostCardsLayout.vue";
import PostService from "../../services/PostService";
import { useAuthStore } from "../../store/auth";
const services = new PostService();
const postlist = services.getPosts();
const store = useAuthStore();

onMounted(async () => {
  await services.fetchAll();
});
</script>

<style scoped></style>

<template>
  <v-container
    class="d-flex justify-center flex-xl-wrap flex-lg-wrap flex-sm-wrap align-content-center"
  >
    <PostCard
      v-for="post in Posts"
      :key="post.id"
      :Post="post"
      @id_post="updatePost"
    ></PostCard>
  </v-container>
</template>

<script setup lang="ts">
import PostCard from "../../components/Posts/PostCard.vue";
import { IPost } from "../../Interfaces/IPost";

defineProps({ Posts: Array<IPost> });
const emits = defineEmits(["edit_post"]);

const updatePost = (id_post: number) => {
  emits("edit_post", id_post);
};
</script>

<style scoped></style>

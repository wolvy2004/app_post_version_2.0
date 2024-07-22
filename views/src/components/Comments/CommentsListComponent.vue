<template>
  <TransitionGroup name="list">
    <CommentItemComponent
      v-for="comment in commentsList"
      :key="comment.id"
      :comment="comment"
      @delete_comment="eliminarComentario"
    />
  </TransitionGroup>
</template>

<script setup lang="ts">
import CommentService from "../../services/CommentService.ts";
import CommentItemComponent from "./CommentItemComponent.vue";
import { onMounted, watch } from "vue";

const service = new CommentService();
const commentsList = service.getComments();

async function getComments(post: number) {
  await service.fetchAllbyPost(post);
}

const props = defineProps<{ id_post: number | undefined }>();
onMounted(async () => {
  if (props.id_post) {
    getComments(props.id_post);
  }
});

watch(commentsList, () => {
  if (props.id_post) getComments(props.id_post);
});
const eliminarComentario = (id: number) => {
  async () => {
    await service.deleteComment(id);
  };
};
</script>

<style scoped>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>

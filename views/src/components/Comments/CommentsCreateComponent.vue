<template>
  <v-form>
    <v-text-field
      name="comentario"
      label="escribir un comentario"
      id="id"
      prepend-inner-icon="mdi-pencil"
      v-model="comentario"
    />
    <v-btn
      color="primary"
      variant="outlined"
      width="100%"
      prepend-icon="mdi-save"
      @click="guardarComment"
      >guardar comentario</v-btn
    >
  </v-form>
</template>

<script setup lang="ts">
import { ref } from "vue";
import CommentService from "../../services/CommentService";
import { useAuthStore } from "../../store/auth";
const comentario = ref<string>();
const service = new CommentService();
const store = useAuthStore();
const props = defineProps<{ id?: number }>();

const guardarComment = async () => {
  const new_comment = {
    comentario: comentario.value,
    id_user: store.getID,
    id_post: props.id,
  };
  await service.saveComment(new_comment);
  comentario.value = "";
};
</script>

<style scoped></style>

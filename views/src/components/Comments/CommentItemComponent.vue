<template>
  <v-card class="ma-2 pa-1" variant="flat" :subtitle="comment.user?.username">
    <v-card-text> {{ comment.comentario }} </v-card-text>
    <template v-slot:prepend>
      <v-avatar size="24" color="red">
        <img
          width="100%"
          :src="
            'http://localhost:8080/uploads/' + comment.user?.picture_profile
          "
          alt="alt"
        />
      </v-avatar>
    </template>
    <template v-slot:append>
      <v-btn
        @click="edit_comment"
        :disabled="false"
        color="primary"
        size="small"
        icon="mdi-trash-can"
        variant="text"
      ></v-btn>
      <v-btn
        @click="delete_comment"
        color="primary"
        size="small"
        icon="mdi-pencil"
        variant="text"
      ></v-btn>
    </template>
    <v-divider></v-divider>
  </v-card>
</template>

<script setup lang="ts">
import IComment from "../../Interfaces/IComment.ts";

import { useAuthStore } from "../../store/auth.ts";

const emits = defineEmits(["edit_comment", "delete_comment"]);

const edit_comment = () => {
  emits("edit_comment", props.comment.id);
};

const delete_comment = () => {
  emits("delete_comment", props.comment.id);
};

const store = useAuthStore();
const props = defineProps<{ comment: IComment }>();
</script>

<style scoped></style>

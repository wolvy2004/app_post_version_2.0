<template>
  <v-card
    class="mx-3 my-2 border-sm border-opacity-55"
    :subtitle="dayjs(Post.created_at).fromNow()"
    :title="Post.titulo"
    elevation="10"
    min-width="300px"
    width="400px"
  >
    <template v-slot:prepend>
      <v-avatar size="48">
        <v-img
          alt="Post.user?.picture_profile"
          :src="'http://localhost:8080/uploads/' + Post.user?.picture_profile"
        ></v-img>
      </v-avatar>
    </template>
    <template v-if="Post.user?.username === store.getUsername" v-slot:append>
      <v-icon @click="editPost" color="primary">mdi-pencil</v-icon>
    </template>
    <v-img
      class="align-end text-white"
      height="300px"
      cover
      :src="'http://localhost:8080/imgs/' + Post.picture"
    >
    </v-img>

    <v-card-subtitle primary-title> </v-card-subtitle>
    <v-card-text>
      {{ Post.descripcion }}
    </v-card-text>
    <v-card-actions class="align-center justify-space-around">
      <v-container>
        <v-btn
          class="ma-1"
          size="large"
          color="blue-lighten-2"
          prepend-icon="mdi-thumb-up"
          >{{ Post.likes }}</v-btn
        >
        <v-btn
          size="large"
          class="ma-1"
          color="blue-lighten-2"
          prepend-icon="mdi-thumb-down"
          >{{ Post.dislikes }}</v-btn
        >
      </v-container>

      <v-spacer></v-spacer>
      <v-btn
        :disabled="!store.getAuthorized"
        color="blue-lighten-2"
        variant="outlined"
        prepend-icon="mdi-comment"
        class="ma-2"
        @click="reveal = true"
        >comentar</v-btn
      >
    </v-card-actions>
    <v-expand-transition>
      <v-card
        v-if="reveal"
        variants="plain"
        class="position-absolute w-100 pa-6 overflow-auto"
        height="100%"
        style="bottom: 0"
      >
        <comment-list :id_post="Post.id" />
        <comment-create :id="Post.id" class="" />

        <v-card-actions class="bottom-0 ma-6">
          <v-btn
            color="primary"
            @click="reveal = false"
            prepend-icon="mdi-close"
            >cerrar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-expand-transition>
  </v-card>

  <h1></h1>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { IPost } from "../../Interfaces/IPost";
import { useAuthStore } from "../../store/auth";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import duration from "dayjs/plugin/duration";
import es from "dayjs/locale/es";
import CommentCreate from "../Comments/CommentsCreateComponent.vue";
import CommentList from "../Comments/CommentsListComponent.vue";
dayjs.locale(es);
dayjs.extend(duration);
dayjs.extend(relativeTime);

const reveal = ref<Boolean>(false);
const props = defineProps<{ Post: IPost }>();
const store = useAuthStore();
const emits = defineEmits(["id_post"]);
const editPost = () => {
  emits("id_post", props.Post.id);
};
</script>

<style scoped></style>

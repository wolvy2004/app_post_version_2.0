<template>
  <v-form class="bg-white pa-10">
    <v-dialog
      v-model="dialog"
      persistent
      :overlay="false"
      max-width="500px"
      transition="dialog-transition"
    >
      <v-card>
        <v-card-actions>
          <v-icon size="128" color="success">mdi-trash-can</v-icon>
          <v-card-title primary-title> Desea eliminar el post? </v-card-title>
          <v-btn color="success" icon="mdi-check" @click="deletePost"></v-btn>
          <v-btn color="error" icon="mdi-close" @click="dialog = false"></v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-text-field
      flat
      theme="light"
      variant="solo"
      v-model="titulo"
      :rules="[(v:string) => !!v || 'campo requerido']"
      clearable
      name="titulo"
      label="Que estas pensando...?"
      class="bg-white text-body-1 font-weight-medium text-{16}-h1"
      auto-select-first
      id="id"
      maxlength="100"
      counter
    ></v-text-field>

    <v-container grid-list-xs>
      <v-row col="12">
        <v-col col="6">
          <v-textarea
            v-model="descripcion"
            prepend-inner-icon="mdi-lightbulb-on"
            clearable
            name="descricion"
            label="cuentanos más..."
            id="id"
            :rules="[(v:string) => !!v || 'campo requerido']"
            maxlength="200"
            counter
          ></v-textarea>
          <v-file-input
            :rules="[(v:string) => !!v || 'campo requerido']"
            label="elige una imagen"
            @change="upload_file"
          ></v-file-input
        ></v-col>
        <v-col col="6">
          <v-img
            cover
            width="100%"
            height="100%"
            class="preview position-relative"
            :src="preview"
            alt=""
          />
        </v-col>
      </v-row>
    </v-container>
    <v-row no gutter>
      <v-col cols="6"> </v-col>
      <v-col cols="6">
        <v-btn
          width="50%"
          variant="text"
          prepend-icon="mdi-delete"
          color="error"
          @click="dialog = true"
          >eliminar post</v-btn
        ><v-btn
          variant="text"
          width="50%"
          prepend-icon="mdi-content-save"
          color="success"
          @click="editPost"
          >editar post</v-btn
        ></v-col
      >
    </v-row>
  </v-form>
</template>

<script setup lang="ts">
import PostService from "../../services/PostService.ts";
import { ref, onMounted } from "vue";
import { useAuthStore } from "../../store/auth.ts";
import { IPost } from "../../Interfaces/IPost.ts";

const props = defineProps<{ id: number }>();

const emit = defineEmits(["dialog"]);
const store = useAuthStore();
const service = new PostService();
const post = service.getPost();
const titulo = ref<string>("");
const descripcion = ref<string>("");
const preview = ref<string>("");
const file = ref<File | null>(null);
const id = ref<number>();
const dialog = ref<boolean>(false);

onMounted(async () => {
  await service.fetchById(props.id.toString());
  if (post.value.titulo) {
    titulo.value = post.value.titulo;
  }
  if (post.value.descripcion) {
    descripcion.value = post.value.descripcion;
  }

  preview.value = "http://localhost:8080/imgs/" + post.value.picture;
  id.value = post.value.id;
});

const deletePost = async () => {
  if (id.value) {
    const response = await service.deletePost(id.value?.toString());
    if (response.status === 200) {
      alert("post eliminado correctamente");
      emit("dialog", false);
    }
  }
};
const upload_file = (event: Event) => {
  const target = event.target as HTMLInputElement;
  const selectElement = target.files ? target.files[0] : null;

  if (selectElement) {
    const allowedTypes = [
      "image/jpeg",
      "image/png",
      "image/gif",
      "image/bmp",
      "image/webp",
      "image/tiff",
    ];
    if (!allowedTypes.includes(selectElement.type)) {
      alert("tipo no permitido");
      file.value = null;
    } else {
      file.value = selectElement;
      preview.value = URL.createObjectURL(selectElement);
    }
  }
};

const editPost = async () => {
  if (!titulo.value || !descripcion.value) {
    alert("titulo y descripcion deben tener valor");
  } else {
    if (!file.value && !preview.value) {
      alert("debe seleccionar una imagen");
    } else {
      const updatePost: IPost = {
        titulo: titulo.value,
        descripcion: descripcion.value,
        picture: preview.value,
        is_active: 1,
        created_at: post.value.created_at,
        updated_at: post.value.updated_at,
        id: post.value.id,
        likes: post.value.likes,
        dislikes: post.value.dislikes,
        file: file.value,
      };
      if (store.getID) {
        updatePost.id_user = store.getID;
      }
      const response = await service.editPost(updatePost);
      if (response.status === 200) {
        alert("post creado correctamente");
        emit("dialog", false);
      }
    }
  }
};
</script>

<style scoped></style>

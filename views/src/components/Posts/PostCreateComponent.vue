<template>
  <v-form class="bg-white pa-10">
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

    <v-btn prepend-icon="mdi-content-save" color="primary" @click="savePost"
      >guardar post</v-btn
    >
  </v-form>
</template>

<script setup lang="ts">
import PostService from "../../services/PostService.ts";
import { ref } from "vue";
import { useAuthStore } from "../../store/auth.ts";
import { IPost } from "../../Interfaces/IPost.ts";

const emit = defineEmits(["dialog"]);
const store = useAuthStore();
const service = new PostService();

const titulo = ref<string>("");
const descripcion = ref<string>("");
const preview = ref<string>("");
const file = ref<File | null>(null);

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

const savePost = async () => {
  if (!titulo.value || !descripcion.value || !file.value) {
    alert("todos los campos son requeridos");
  } else {
    const newPost: IPost = {
      titulo: titulo.value,
      descripcion: descripcion.value,
      picture: file.value,
      is_active: 1,
      created_at: "",
      updated_at: "",
    };
    if (store.getID) {
      newPost.id_user = store.getID;
    }
    const response = await service.createPost(newPost);
    if (response.status === 200) {
      alert("post creado correctamente");
      emit("dialog", false);
    }
  }
};
</script>

<style scoped></style>

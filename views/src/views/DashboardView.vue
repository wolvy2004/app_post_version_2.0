<template>
  <h1>Dashboard</h1>
  <v-btn
    elevation="10"
    variant="text"
    color="warning"
    class="ml-5 mt-10"
    prepend-icon="mdi-arrow-left"
    >volver</v-btn
  >
  <v-btn
    elevation="24"
    rounded="0"
    variant="outlined"
    outlined
    color="pink"
    class="ml-5 mt-10"
    prepend-icon="mdi-content-save"
    >guardar</v-btn
  >
  <v-btn
    elevation="24"
    variant="tonal"
    color="error"
    class="ml-5 mt-10"
    prepend-icon="mdi-cancel"
    >cancelar</v-btn
  >
  <!-- <v-container>
    <v-row justify="space-around">
      <v-date-picker color="#D405FF"></v-date-picker>
    </v-row>
  </v-container> -->

  <!-- <v-container>
    <v-row justify="space-around">
      <v-slider
        v-model="precio"
        color="orange"
        :max="max"
        :min="min"
        width="500"
        class="align-center"
        hide-details
      >
        <template v-slot:append>
          <v-text-field
            v-model="precio"
            density="compact"
            style="width: 70px"
            type="number"
            hide-details
            single-line
          ></v-text-field>
        </template> </v-slider
    ></v-row>
    <h2>cantidad {{ Math.floor(precio) }}</h2>
  </v-container> -->
  <v-form>
    <v-text-field
      label="ingrese su email"
      required="true"
      type="email"
      color="#D405FF"
      prepend-inner-icon="mdi-email"
      class="mx-10 mt-16"
    ></v-text-field>
    <v-text-field
      label="ingrese su password"
      required="true"
      type="password"
      color="#FF05AD"
      prepend-inner-icon="mdi-key"
      class="mx-10"
    ></v-text-field>
    <v-file-input
      label="File input"
      prepend-icon="mdi-camera"
      variant="filled"
      class="mx-10"
    ></v-file-input>
    <v-select class="mx-10" :items="items" label="Compact"></v-select>
    <v-btn class="mx-10" color="success" prepend-icon="mdi-send-variant"
      >enviar</v-btn
    >
  </v-form>
</template>

<script setup lang="ts">
import { ref } from "vue";
const items = ref<Array<string>>(["Foo", "Bar", "Fizz", "Buzz"]);
const max = ref<number>(100);
const min = ref<number>(0);
const precio = ref<number>(0);
</script>

<style scoped></style>

<template>
  <main>
    <div>
      <input type="text" v-model="items" />
      <button @click="agregarItem">Agregar item</button>
    </div>
    <div class="lista">
      <div class="sin_items" v-if="lista.length < 1">Sin items en la lista</div>
      <TransitionGroup name="list" tag="ul">
        <li v-for="(item, id) in lista" key="id">
          <span class="indice">{{ id + 1 }}</span
          ><span class="item"> {{ item }}</span>
          <button class="delete" @click="eliminarItem(item)">X</button>
        </li>
      </TransitionGroup>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, Ref } from "vue";
const items: Ref<string> = ref("");
const lista: Ref<Array<String>> = ref([]);

function agregarItem() {
  if (items.value.length > 0) {
    lista.value.push(items.value);
    items.value = "";
  }
}
function eliminarItem(item: String) {
  lista.value = lista.value.filter((e) => e != item);
}
</script>

<style scoped>
button {
  margin: 1em;
}
main {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  width: 100%;
  margin-top: 150px;
}

.delete {
  grid-column-start: 3;
  text-align: center;
  width: 30px;
  height: 30px;
  background-color: red;
  color: white;
  line-height: 15px;
  border-radius: 50%;
  font-size: 15px;
  font-weight: 900;
}
.sin_items {
  color: #5f5d5d;
  text-align: center;
  text-transform: uppercase;
  font-size: 1.2em;
  text-wrap: wrap;
}
ul {
  display: flex;
  flex-direction: column;
  list-style: none;
  justify-content: space-between;
  align-items: center;
}
.lista li {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  align-items: center;
}
.id {
  grid-column-start: 1;
  grid-column-end: 1;
}
.item {
  grid-column-start: 2;
  grid-column-end: 2;
}
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease-in-out;
}
.list-move,
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(-100px);
}
</style>

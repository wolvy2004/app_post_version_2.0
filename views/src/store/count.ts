import { defineStore } from "pinia";

export const useCountStore = defineStore("count", {
  state: () => ({
    count: 0,
    nombre: "",
    rol: "admin",
  }),
  getters: {
    multiplicar: (state) => {
      return state.count * 2;
    },
    reverso: (state) => {
      return state.nombre.split("").reverse().join("");
    },
  },
  actions: {
    agregar(value: number) {
      this.count += value;
    },
    modificarNombre(value: string) {
      this.nombre = value;
    },
  },
  persist: true,
});

import { defineStore } from "pinia";
import IAuth from "../Interfaces/IAuth";

export const useAuthStore = defineStore("auth", {
  // valores iniciales de los stores
  state: () => ({
    access_jwt: "" as string | null,
    username: "" as string | null,
    rol: "" as string | null,
    authorized: false as boolean,
    picture_profile: "" as string | null,
    id: 0 as number | null,
  }),
  // mutaciones en forma de computadas (getters)
  getters: {
    getAccess_token: (state) => {
      return state.access_jwt;
    },
    getRol: (state) => {
      return state.rol;
    },
    getUsername: (state) => {
      return state.username;
    },
    getAuthorized: (state) => {
      return state.authorized;
    },
    getPictureProfile: (state) => {
      return state.picture_profile;
    },
    getID: (state) => {
      return state.id;
    },
  },

  actions: {
    isAuth(data: IAuth) {
      this.rol = data.rol;
      this.access_jwt = data.access_jwt;
      this.username = data.username;
      this.authorized = true;
      this.picture_profile = data.picture_profile;
      this.id = data.id;
    },
    logout() {
      this.access_jwt = "";
      this.username = "";
      this.rol = "";
      this.authorized = false;
      this.picture_profile = "";
      this.id = 0;
    },
  },
  persist: true,
});

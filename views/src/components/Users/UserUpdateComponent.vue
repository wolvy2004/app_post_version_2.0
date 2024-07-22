0
<template>
  <main>
    <h1>Registro de Usuario</h1>
    <form @submit.prevent>
      <div>
        <v-text-field
          prepend-inner-icon="mdi-account"
          name="name"
          label="nombre de usuario"
          :rules="UsernameRules"
          required
          v-model="username"
        ></v-text-field>
        <v-text-field
          prepend-inner-icon="mdi-email"
          name="email"
          label="email"
          :rules="EmailRules"
          v-model="email"
        ></v-text-field>
        <v-text-field
          prepend-inner-icon="mdi-lock"
          name="password"
          type="password"
          label="password"
          :rules="[(v:string) => !!v || 'password requerido']"
          v-model="password"
        ></v-text-field>
        <v-select
          v-model="rol"
          :rules="[(v:string) => !!v || 'rol es requerido']"
          label="Seleccione un rol"
          :items="roles"
          :item-props="itemProps"
        ></v-select>
        <v-select
          v-model="is_active"
          :rules="[(v:number) => (!!v || v === 0)|| 'rol es requerido']"
          label="activo"
          :items="is_active_select"
          :item-props="activeProps"
        ></v-select>
        <v-file-input
          :rules="[(v:string) => !!v || 'imagen requerido']"
          label="File input"
          @change="upload_file"
          name="upload_file"
        ></v-file-input>
      </div>
      <picture class="position-relative">
        <img class="preview position-relative" :src="preview" alt="" />
        <v-btn
          flat
          color="grey-lighten-2"
          size="x-small"
          v-if="preview != preview_image"
          @click="removeImage"
          class="position-absolute top-0 right-0 mt-2 mr-2"
          icon="mdi-close"
        ></v-btn>
      </picture>
      <div>
        <v-btn
          width="100%"
          prepend-icon="mdi-send"
          @click.prevent="create"
          color="success"
        >
          enviar</v-btn
        >
      </div>
    </form>
  </main>
</template>

<script setup lang="ts">
import { onMounted, ref } from "vue";
import UserService from "../../services/UserService.ts";
import RolService from "../../services/RolService.ts";
import { useRouter } from "vue-router";
import IRol from "../../Interfaces/IRol.ts";

const props = defineProps<{ id: number }>();
const preview_image = "../imgs/preview.jpg";
const User = new UserService();
const id_user = ref<number>();
const rol_service = new RolService();
const roles = rol_service.getRoles();
const itemProps = (rol: IRol) => {
  return { title: rol.descripcion, value: rol.id };
};

onMounted(async () => {
  await User.fetch_Id(props.id.toString());
  await rol_service.fetchAll();
  if (userUpdate.value.username) {
    username.value = userUpdate.value.username;
  }
  if (userUpdate.value.password) {
    password.value = userUpdate.value.password;
  }
  if (userUpdate.value.email) {
    email.value = userUpdate.value.email;
  }
  if (userUpdate.value.rol) {
    if (userUpdate.value.rol.id) {
      rol.value = userUpdate.value.rol.id;
    }
  }
  id_user.value = userUpdate.value.id;
  created_at.value = userUpdate.value.created_at;
  updated_at.value = new Date();
  preview.value =
    "http://localhost:8080/uploads/" + userUpdate.value.picture_profile;
});
const router = useRouter();
const exist_username = ref<boolean>(false);
const exist_email = ref<boolean>(false);
const username = ref<string>("");
const password = ref<string>("");
const email = ref<string>("");
const rol = ref<number>();
const userUpdate = User.getUser();
const created_at = ref<Date>();
const updated_at = ref<Date>();
const is_active = ref<number>();
interface IActivo {
  desc: string;
  valor: number;
}
const is_active_select = ref<Array<IActivo>>([
  { desc: "Activo", valor: 1 },
  { desc: "Inactivo", valor: 0 },
]);

const activeProps = (is_active_select: IActivo) => {
  return {
    title: is_active_select.desc,
    value: is_active_select.valor,
  };
};

const EmailRules = [
  (value: string) => !!value || "email es requerido",
  async () => {
    if (email.value != userUpdate.value.email) {
      return !(await checkEmail()) || "el email existe";
    }
  },

  (value: string) =>
    (value && value.length >= 6) ||
    "el username tiene que tener mas de 6 caracteres",
  (value: string) =>
    (!!value && /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/.test(value)) ||
    "el email debe tener un formato valido",
];
const UsernameRules = [
  (value: string) => !!value || "username es requerido",
  async () => {
    if (username.value != userUpdate.value.username) {
      return !(await checkUsername()) || "el usuario existe";
    }
  },
  (value: string) =>
    (value && value.length >= 6) ||
    "el username tiene que tener mas de 6 caracteres",
];

const file = ref<File | null>(null);
const preview = ref<string>(preview_image);
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
const removeImage = () => {
  if (preview.value) {
    preview.value = "../imgs/preview.jpg";
  }
};
async function checkUsername() {
  if (username.value.length >= 6) {
    return await User.checkUsername(username.value.toLowerCase());
  }
  return false;
}
async function checkEmail() {
  if (username.value.length >= 6) {
    console.log(await User.checkEmail(email.value.toLowerCase()));
    return await User.checkEmail(email.value.toLowerCase());
  }
  return false;
}
const create = async () => {
  if (
    username.value === "" ||
    password.value === "" ||
    email.value === "" ||
    file.value === null ||
    exist_email.value === true ||
    exist_username.value === true
  ) {
    alert(
      "debe rellenar todos los campos y el username y email no pueden ser ya utilizados"
    );
  } else {
    const newUser = {
      id: id_user.value,
      username: username.value,
      password: password.value,
      email: email.value,
      rol: rol.value,
      pix_profile: file.value,
      created_at: created_at.value,
      updated_at: updated_at.value,
      is_active: is_active.value,
    };
    const exito = await User.updateUser(newUser);
    if (exito.status === 201) {
      alert(exito.message);
      router.push({ name: "users" });
    } else {
      alert(exito.message);
    }
  }
};
</script>

<style scoped>
main {
  margin-top: 0;
  width: 600px;
  height: 600px;
  position: relative;
  top: 0;
  left: 0;
  display: flex;

  flex-direction: column;
  align-items: center;
}
picture {
  width: 400px;
  height: 400px;
  object-fit: cover;
  border: 2px solid black;
}
span {
  position: absolute;
  right: 5px;
  top: 5px;
  color: red;
}
h1 {
  font-size: 1.5em;
  margin: 1.5em;
}
form {
  border: 1px solid #4e4d4d;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 30px;
  width: 900px;
  height: 500px;
  justify-content: center;
  align-items: center;
  border-radius: 10px;
  padding: 1rem;
}

input::placeholder {
  position: absolute;
  color: #9a9a9a;
  top: 10px;
}

.preview {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>

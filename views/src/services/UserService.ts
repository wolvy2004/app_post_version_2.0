import { ref, Ref } from "vue";
import IUser from "../Interfaces/IUser";
import axios from "../plugins/axios";
import { useAuthStore } from "../store/auth.ts";
import IAuth from "../Interfaces/IAuth";

class UserService {
  private users: Ref<Array<IUser>>;
  private user: Ref<IUser>;
  private store;

  constructor() {
    this.users = ref<Array<IUser>>([]);
    this.user = ref<IUser>({});
    this.store = useAuthStore();
  }

  getUsers(): Ref<Array<IUser>> {
    return this.users;
  }
  getUser(): Ref<IUser> {
    return this.user;
  }

  async login(
    username: string,
    password: string
  ): Promise<{ code: number; message: string }> {
    const user = {
      username: username,
      password: password,
    };

    const response = await axios
      .post(`/login`, user, {
        baseURL: "http://127.0.0.1:8080",
      })
      .then((response) => {
        if (response.data.code === 200) {
          const auth: IAuth = {
            access_jwt: response.data.access_token,
            username: response.data.username,
            rol: response.data.rol.descripcion,
            authorized: response.data.authorized,
            picture_profile: response.data.picture_profile,
            id: response.data.id,
          };
          this.store.isAuth(auth);
          return { code: response.data.code, message: "acceso permitido" };
        }

        return { code: response.data.code, message: response.data.message };
      })
      .catch((error) => {
        return { code: error.code, message: error.message };
      });
    return response;
  }

  async fetchAll(): Promise<void> {
    try {
      await axios
        .get("users", {
          headers: {
            Authorization: "Bearer " + this.store.getAccess_token,
            "Content-Type": "application/json",
          },
        })
        .then((response) => {
          console.log(response.data);
          this.users.value = response.data;
        })
        .catch((e) => {
          console.log(e.message);
        });
    } catch (error) {
      console.log(error);
    }
  }
  async fetch_Id(id: string | string[]): Promise<void> {
    await axios
      .get(`/users/${id}`, {
        headers: {
          Authorization: "Bearer " + this.store.getAccess_token,
          "Content-Type": "application/json",
        },
      })
      .then((response) => {
        this.user.value = response.data;
      })
      .catch((e) => console.log(e));
  }
  async createUser(user: IUser): Promise<{ status: number; message: string }> {
    const formData = new FormData();

    if (user.username) {
      formData.append("username", user.username);
    }
    if (user.email) {
      formData.append("email", user.email);
    }
    if (user.password) {
      formData.append("password", user.password);
    }
    if (user.pix_profile) {
      formData.append("file", user.pix_profile);
    }
    if (user.rol) {
      formData.append("rol", user.rol.toString());
    }

    formData.append("directory", "uploads");
    const response = await axios.post("users/create/", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
  async updateUser(user: IUser): Promise<{ status: number; message: string }> {
    const formData = new FormData();
    if (user.username) {
      formData.append("username", user.username);
    }
    if (user.email) {
      formData.append("email", user.email);
    }
    if (user.password) {
      formData.append("password", user.password);
    }
    if (user.pix_profile) {
      formData.append("file", user.pix_profile);
    }
    if (user.rol) {
      formData.append("rol", user.rol.toString());
    }
    if (user.created_at) {
      formData.append("created_at", user.created_at.toString());
    }
    if (user.updated_at) {
      formData.append("updated_at", user.updated_at.toString());
    }
    if (user.id) {
      formData.append("id", user.id.toString());
    }
    if (user.is_active) {
      formData.append("is_active", user.is_active.toString());
    }
    formData.append("directory", "upload");
    const response = await axios.post("users/" + user.id, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
  async deleteUser(
    id: string | string[]
  ): Promise<{ message: string; status: number }> {
    const response = await axios.delete(`/users/${id}`, {
      headers: {
        "Content-Type": "Application/Json",
        Authorization: "Bearer " + this.store.access_jwt,
      },
    });
    if (response.data.status != 403) {
      this.fetchAll();
    }
    return { status: response.data.status, message: response.data.message };
  }
  async checkUsername(username: string | string[]): Promise<boolean> {
    const response = await axios.get(`/check-username/${username}`);
    return response.data;
  }
  async checkEmail(email: string | string[]): Promise<boolean> {
    const email_check = { email: email };
    const response = await axios.post(`/check-email`, email_check);
    return response.data;
  }
}

export default UserService;

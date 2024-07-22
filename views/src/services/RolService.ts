import { ref, Ref } from "vue";
import IRol from "../Interfaces/IRol";
import axios from "../plugins/axios";

class RolService {
  private roles: Ref<Array<IRol>>;
  private rol: Ref<IRol>;

  constructor() {
    this.roles = ref<Array<IRol>>([]);
    this.rol = ref<IRol>({});
  }

  getRoles(): Ref<Array<IRol>> {
    return this.roles;
  }
  getRol(): Ref<IRol> {
    return this.rol;
  }
  async fetchAll(): Promise<void> {
    await axios
      .get("roles")
      .then((response) => {
        console.log(response.data);
        this.roles.value = response.data;
      })
      .catch((err) => {
        console.log(err);
      });
  }
  async fetchById(id: number): Promise<void> {
    await axios
      .get(`roles/${id}`)
      .then((response) => {
        this.rol.value = response.data;
      })
      .catch((error) => console.log(error));
  }
}

export default RolService;

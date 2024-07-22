import { Ref, ref } from "vue";
import { IPost } from "../Interfaces/IPost";
import axios from "../plugins/axios";
import { useAuthStore } from "../store/auth";

class PostService {
  private Posts: Ref<Array<IPost>>;
  private Post: Ref<IPost>;
  private PostsByUser: Ref<Array<IPost>>;
  private store = useAuthStore();

  constructor() {
    this.Posts = ref<Array<IPost>>([]);
    this.PostsByUser = ref<Array<IPost>>([]);
    this.Post = ref<IPost>({});
  }
  getPostsByUser(): Ref<Array<IPost>> {
    return this.PostsByUser;
  }
  getPosts(): Ref<Array<IPost>> {
    return this.Posts;
  }
  getPost(): Ref<IPost> {
    return this.Post;
  }
  /// Metodos para retornar Post
  async fetchAll(): Promise<void> {
    await axios.get("posts").then((response) => {
      this.Posts.value = response.data.reverse();
    });
  }
  async fetchById(id: string | string[]) {
    await axios.get(`posts/${id}`).then((response) => {
      this.Post.value = response.data;
    });
  }
  async fetchByUser(id_user: string | string[]) {
    await axios.get(`posts/user/${id_user}`).then((response) => {
      this.PostsByUser.value = response.data;
    });
  }
  async createPost(post: IPost): Promise<{ status: number; message: string }> {
    let formData = new FormData();
    if (post.titulo) {
      formData.append("titulo", post.titulo);
    }
    if (post.descripcion) {
      formData.append("descripcion", post.descripcion);
    }
    if (post.picture) {
      formData.append("file", post.picture);
    }
    if (post.id_user) {
      formData.append("id_user", post.id_user.toString());
    }
    formData.append("directory", "imgs");
    if (this.store.getUsername) {
      formData.append("username", this.store.getUsername);
    }

    const response = await axios.post("posts", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
  async editPost(post: IPost): Promise<{ status: number; message: string }> {
    let formData = new FormData();
    if (post.titulo) {
      formData.append("titulo", post.titulo);
    }
    if (post.descripcion) {
      formData.append("descripcion", post.descripcion);
    }
    if (post.picture) {
      formData.append("picture", post.picture);
    }
    if (post.id_user) {
      formData.append("id_user", post.id_user.toString());
    }
    formData.append("directory", "imgs");
    if (this.store.getUsername) {
      formData.append("username", this.store.getUsername);
    }
    if (post.id) {
      formData.append("id", post.id.toString());
    }
    if (post.created_at) {
      formData.append("created_at", post.created_at.toString());
    }
    if (post.updated_at) {
      formData.append("updated_at", post.updated_at.toString());
    } else {
      formData.append("updated_at", "");
    }
    if (post.dislikes != null) {
      formData.append("dislikes", post.dislikes.toString());
    }
    if (post.likes != null) {
      formData.append("likes", post.likes.toString());
    }
    if (post.file) {
      formData.append("file", post.file);
    }
    if (post.is_active) {
      formData.append("is_active", post.is_active.toString());
    }

    const response = await axios.post(`posts/${post.id}`, formData, {
      headers: {
        "Content-Type": "multipart/form-data",
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
  async deletePost(
    id: string | string[]
  ): Promise<{ status: number; message: string }> {
    const response = await axios.delete(`posts/${id}`, {
      headers: {
        "Content-Type": "application/json",
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
}
export default PostService;

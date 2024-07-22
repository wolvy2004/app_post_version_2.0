import IComment from "../Interfaces/IComment";
import axios from "../plugins/axios";
import { useAuthStore } from "../store/auth";
import { ref, Ref } from "vue";

class CommentService {
  private comments: Ref<Array<IComment>>;
  private comment: Ref<IComment>;
  private store = useAuthStore();

  constructor() {
    this.comments = ref<IComment[]>([]);
    this.comment = ref<IComment>({});
  }
  getComments(): Ref<IComment[]> {
    return this.comments;
  }
  getComment(): Ref<IComment> {
    return this.comment;
  }
  async fetchAllbyPost(id: number): Promise<void> {
    await axios
      .get(`comments/${id}`, {
        headers: {
          Authorization: "Bearer " + this.store.getAccess_token,
        },
      })
      .then((response) => {
        this.comments.value = response.data;
      })
      .catch((error) => {
        console.error(error);
      });
  }
  async saveComment(Comment: {
    comentario?: string;
    id_user?: number;
    id_post?: number;
  }): Promise<{ status: number; message: string }> {
    const response = await axios.post(`comments`, Comment, {
      headers: {
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
  async deleteComment(id: number) {
    const response = await axios.delete(`comments/${id}`, {
      headers: {
        Authorization: "Bearer " + this.store.getAccess_token,
      },
    });
    return { status: response.data.status, message: response.data.message };
  }
}
export default CommentService;

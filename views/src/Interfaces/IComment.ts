import { IPost } from "./IPost";
import IUser from "./IUser";

interface IComment {
  comentario?: string;
  user?: IUser;
  post?: IPost;
  id_user?: number;
  id_post?: number;
  id?: number;
  created_at?: string;
  updated_at?: any;
  is_active?: number;
}

export default IComment;

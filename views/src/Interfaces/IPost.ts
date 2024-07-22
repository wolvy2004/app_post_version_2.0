import IUser from "./IUser";

export interface IPost {
  id?: number;
  created_at?: Date | string;
  updated_at?: Date | null | string;
  is_active?: number;
  id_user?: number;
  titulo?: string;
  descripcion?: string;
  likes?: number;
  dislikes?: number;
  picture?: string | null;
  user?: IUser;
  file?: File | null;
}

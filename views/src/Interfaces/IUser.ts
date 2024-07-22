import IRol from "./IRol";
export default interface IUser {
  id?: number;
  created_at?: Date;
  updated_at?: null | Date;
  is_active?: number;
  username?: string;
  email?: string;
  password?: string;
  rol?: IRol | null;
  pix_profile?: File | null;
  picture_profile?: string;
}

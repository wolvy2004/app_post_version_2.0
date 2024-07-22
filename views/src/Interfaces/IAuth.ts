export default interface IAuth {
  access_jwt: string;
  username: string;
  rol: string;
  authorized: boolean;
  picture_profile: string;
  id: number;
}

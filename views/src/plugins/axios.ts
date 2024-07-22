import Axios from "axios";

const axios = Axios.create({
  baseURL: "http://127.0.0.1:8080/apiv1/",
  timeout: 5000,
});
export default axios;

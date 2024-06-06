import Environment from "@/environments/environment";
import axios from "axios";
import AuthService from "./AuthService";
import { useSnackbarStore } from "../store/useSnackbarStore";

const snackbar = useSnackbarStore();

class HttpService {
  apiUrl = Environment.apiUrl;
  async get(url, auth = true) {
    if (auth) {
      return axios
        .get(this.apiUrl + url, {
          headers: {
            Authorization: `Bearer ${AuthService.getToken().token}`,
            Accept: "application/json",
          },
        })
        .catch((error) => {
          this.commonExceptions(error);
          throw error;
        });
    }
    return axios.get(this.apiUrl + url);
  }

  async post(url, body = {}, auth = true) {
    if (auth) {
      return axios
        .post(this.apiUrl + url, body, {
          headers: {
            Authorization: `Bearer ${AuthService.getToken().token}`,
            Accept: "application/json",
          },
        })
        .catch((error) => {
          this.commonExceptions(error);
          throw error;
        });
    }
    return axios.post(this.apiUrl + url, body);
  }

  async put(url, body = {}, auth = true) {
    if (auth) {
      return axios
        .put(this.apiUrl + url, body, {
          headers: {
            Authorization: `Bearer ${AuthService.getToken().token}`,
            Accept: "application/json",
          },
        })
        .catch((error) => {
          this.commonExceptions(error);
          throw error;
        });
    }
    return axios.put(this.apiUrl + url, body);
  }

  async delete(url, auth = true) {
    if (auth) {
      return axios
        .delete(this.apiUrl + url, {
          headers: {
            Authorization: `Bearer ${AuthService.getToken().token}`,
            Accept: "application/json",
          },
        })
        .catch((error) => {
          this.commonExceptions(error);
          throw error;
        });
    }
    return axios.delete(this.apiUrl + url);
  }

  commonExceptions(error) {
    if (error.response.status == 401) {
      window.location.href = "login";
    } else if (error.response.status == 500) {
      snackbar.error("Something went wrong.", "Oops !");
    } else if (error.response.status == 404) {
      snackbar.error("404 resource not found.", "Oops !");
    }
  }
}
export default new HttpService();

import Environment from "@/environments/environment";
import axios from "axios";

class AuthService {
  apiUrl = Environment.apiUrl;

  setToken(token, expiry) {
    let d = new Date(expiry);
    let expires = "expires=" + d.toUTCString();
    document.cookie =
      "studyplanner_access=" + token + ";" + expires + ";path=/";
  }

  getToken() {
    var cookies = document.cookie.split(";");
    var access_token = cookies.find((cookie) =>
      cookie.includes("studyplanner_access=")
    );
    if (!access_token) {
      return { token: null };
    }
    return { token: access_token.split("=")[1] };
  }

  deleteToken() {
    document.cookie =
      "studyplanner_access=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie =
      "studyplanner_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  }

  async validateToken() {
    let token = this.getToken().token;
    return await axios.get("/api/validate-token", {
      headers: { Authorization: `Bearer ${token}` },
    });
  }
}
export default new AuthService();

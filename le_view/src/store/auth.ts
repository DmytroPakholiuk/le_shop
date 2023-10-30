// User and authentication data
import { defineStore } from 'pinia'
import axios from "axios";

const axiosInstance = axios.create()
if (window.localStorage.getItem("LeShopAuth") != null) {
  axiosInstance.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem("LeShopAuth")
}
export const useAuthStore = defineStore('auth', {
  state: () => ({
    clientUrl: "http://view.le.shop:23000",
    apiUrl: "http://api.le.shop:20080",

    clientId: 4,

    isAuthenticated: false,
    state: "",
    code: "",
    accessToken: "",
    refreshToken: "",
    tokenType: "",
    tokenExpiresIn: "",

    axios: axiosInstance

  }),
  actions: {

  },
  // created() {
  //
  // },
  persist: true,
})

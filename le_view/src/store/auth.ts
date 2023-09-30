// User and authentication data
import { defineStore } from 'pinia'
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import axios from "axios";


const axiosInstance = axios.create()
if (window.localStorage.getItem("LeShopAuth")){
  axiosInstance.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem("LeShopAuth")
}
export const useAuthStore = defineStore('auth', {
  state: () => ({
    clientUrl: "http://view.le.shop:23000",
    apiUrl: "http://api.le.shop:20080",

    clientId: 4,

    state: "",
    code: "",
    accessToken: "",

    axios: axiosInstance

  }),
  actions: {

  },
  persist: true,
})

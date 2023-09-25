// User and authentication data
import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    clientUrl: "http://view.le.shop:23000",
    apiUrl: "http://api.le.shop:20080",

    clientId: 4,

  }),
  actions: {

  }
})

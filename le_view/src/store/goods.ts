import { defineStore } from 'pinia'
import {useAuthStore} from "@/store/auth";

export const useGoodsStore = defineStore('goods', {
  state: () => ({
    authStore: useAuthStore(),
    goods: {},
    category: {},
  }),

  actions: {
    fetchGoods(id)
    {
      this.authStore.axios.get(`http://api.le.shop:20080/api/goods/${id}`,
        {

        }).then(resp => {
        this.goods = resp.data.data
        const goodsData = resp.data.data

        this.authStore.axios.get(this.authStore.apiUrl + "/api/categories/" + goodsData.category_id,
          {
            headers: {
              "Authorization": "Bearer " + this.authStore.accessToken
            }
          }).then(resp => {
          const data = resp.data.data
          // this.inputData.category = {name: data.name, id: data.id}
          this.category = {name: data.name, id: data.id}
        })
      })
    }
  }
  // persist: true,
})

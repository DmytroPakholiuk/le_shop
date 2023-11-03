import { defineStore } from 'pinia'
import {useAuthStore} from "@/store/auth";
import {useGoodsStore} from "@/store/goods";

export const useAttributeStore = defineStore('attribute', {
  state: () => ({
    authStore: useAuthStore(),
    goodsStore: useGoodsStore(),
    attributes: [

    ],
  }),
  getters: {
  },
  actions: {
    getAttributeExportData(attributeId) {
      const exportData = {
        attribute_id: undefined,
        goods_id: undefined,
        value: undefined
      };
      const attribute = this.attributes[attributeId];

      exportData.attribute_id = attribute.id;
      exportData.goods_id = attribute.goods_id;
      exportData.value = attribute.value;


      return exportData;
    },

    clearAttributes() {
      this.attributes = []
    },

    async fetchAttributesForGoods(goodsId) {
      if (goodsId !== undefined){
        this.authStore.axios.get(this.authStore.apiUrl + "/api/goods/" + goodsId + "/attributes",
          {
            headers: {
              "Authorization": "Bearer " + this.authStore.accessToken
            }
          }).then(resp => {
          const data = resp.data.data
          this.attributes = data;
        })
      }
    },

    async fetchAttributesForCategory(categoryId) {
      if (categoryId !== undefined){
        this.authStore.axios.get(this.authStore.apiUrl + "/api/categories/" + categoryId + "/attributes",
          {
            headers: {
              "Authorization": "Bearer " + this.authStore.accessToken
            }
          }).then(resp => {
          const data = resp.data.data
          this.attributes = data
          console.log(this.attributes)
        })
      }
    },
  },
  // created() {
  //
  // },
  // persist: true,
})

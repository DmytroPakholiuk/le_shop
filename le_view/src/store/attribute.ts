import { defineStore } from 'pinia'

export const useAttributeStore = defineStore('attribute', {
  state: () => ({
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
      console.log(exportData)


      return exportData;
    }
  },
  // created() {
  //
  // },
  // persist: true,
})

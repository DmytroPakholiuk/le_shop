<template>
  <v-form>
    Attributes
<!--    <v-text-field-->
<!--      v-for="attribute in attributes"-->
<!--      :label="attribute.name"-->
<!--      :key="attribute.id"-->
<!--      v-model="attribute.value"-->
<!--    ></v-text-field>-->

    <goods-attribute-field
      v-for="attribute in attributeStore.attributes"
      :attribute="attribute"
      :key="attribute.id"
      :ref="attribute.name"
    />
  </v-form>
</template>

<script>
import {useAuthStore} from "@/store/auth";
import GoodsAttributeField from "@/components/GoodsAttributeField.vue";
import {useAttributeStore} from "@/store/attribute";
import {useGoodsStore} from "@/store/goods";

export default {
  components: {GoodsAttributeField},
  data: () => ({
    authStore: useAuthStore(),
    attributeStore: useAttributeStore(),
    goodsStore: useGoodsStore(),
  }),

  methods: {

    updateAttributeInputs(goods) {
      this.attributeStore.fetchAttributesForGoods(goods.id)
    },

    sendData() {
      let attributes = this.attributeStore.attributes
      for (const attributesKey in attributes) {
        // let data = {
        //   value: this.attributes[attributesKey].value,
        //   goods_id: this.goods.id,
        //   attribute_id: this.attributes[attributesKey].id,
        // };
        // let data = this.$refs[attributes[attributesKey].name].getInputData
        let data = this.attributeStore.getAttributeExportData(attributesKey)
        this.authStore.axios.post(this.authStore.apiUrl + "/api/goods/" + data.goods_id + "/attributes",
          data,
          {
            headers:{
              Authorization: "Bearer " + this.authStore.accessToken
            }
          }).then(resp => {

        })
      }
    }
  },

  // props: {
  //   goods: Object
  // },

  watch: {
    "goodsStore.goods": {
      handler(toParams, previousParams) {
        this.updateAttributeInputs(toParams)
      },
      deep: true
    },
  },

  async mounted() {
    // await this.attributeStore.fetchAttributesForCategory(this.goodsStore.category.id)
    if (this.goodsStore.goods !== undefined){
      await this.attributeStore.fetchAttributesForGoods(this.goodsStore.goods.id)
    }
  },

  name: "GoodsAttributeForm"
}
</script>

<style scoped>

</style>

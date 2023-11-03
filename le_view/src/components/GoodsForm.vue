<template>
  <v-form>
    <v-text-field
      name="name"
      label="Name"
      :rules="inputRules.nameRules"
      v-model="inputData.name"
    />

    <v-textarea
      name="description"
      label="Description"
      v-model="inputData.description"
    />

    <v-text-field
      name="price"
      label="Price"
      v-model="inputData.price"
      :rules="inputRules.priceRules"
    />

    <v-select
      name="available"
      label="Is available?"
      :items="inputData.availableVariants"
      v-model="inputData.available"
      item-title="valueText"
      item-value="valueBool"
      return-object

    />

    <v-autocomplete
      name="category_id"
      id="category_input"
      label="Category"
      :items="inputData.categoryVariants"
      item-title="name"
      item-value="id"
      @input="fetchCategories"
      v-model="inputData.category"
      return-object
    />

    <goods-attribute-form
      ref="goodsAttributeForm"
    />

    <v-btn @click="sendData()" text="Submit"/>
  </v-form>
</template>

<script>
import {useAuthStore} from "@/store/auth";
import GoodsAttributeForm from "@/components/GoodsAttributeForm.vue";
import {useGoodsStore} from "@/store/goods";

export default {
  components: {GoodsAttributeForm},
  data: () => ({
    authStore: useAuthStore(),
    goodsStore: useGoodsStore(),
    inputData: {
      id: 0,
      name: "",
      description: "",
      price: "",
      available: {valueText: "Yes", valueBool: 1},
      availableVariants: [
        {valueText: "No", valueBool: 0},
        {valueText: "Yes", valueBool: 1}
      ],
      // todo: think how to get such bool values more reusable
      category: {id: null, name: null},
      categoryVariants: [],
      author_id: "",
    },

    inputRules: {
      nameRules: [
        value => {
          if (value) return true

          return 'Name is required.'
        }
      ],
      priceRules: [
        value => {
          if (value) return true

          return 'Price is required.'
        },
        value => {
          if (/^\s*[0-9]+\.?[0-9]{0,2}\s*$/.test(value)){
            return true
          }

          return "Price should be a decimal number, with 2 digits after point delimiter"
        }
      ],
      availableRules: [
        value => {
          if (value) return true

          return 'Availability info is required.'
        }
      ],
    }
  }),

  computed: {
    formData() {
      return {
        id: this.inputData.id === 0 ? null : this.inputData.id,
        name: this.inputData.name,
        description: this.inputData.description,
        price: this.inputData.price,
        available: this.inputData.available.valueBool,
        category_id: this.inputData.category.id
      };
    }
  },

  name: "GoodsForm",

  props: {
    isNew: Boolean,
    // goods: Object
  },

  emits: {
    submitData(payload){
      return true;
    }
  },

  methods: {
    fetchCategories(event) {
      this.authStore.axios.get(this.authStore.apiUrl + "/api/categories?"
        + "per_page=10&"
        + "name=" + event.target.value,
        {
          headers: {
            "Authorization": "Bearer " + this.authStore.accessToken
          }
          // we should include the auth token here. But also better todo send the auth header all the time
        }).then(resp => {
        this.inputData.categoryVariants = resp.data.data
      })
    },

    sendData() {
      let payload = this.formData;
      this.$emit("submitData", payload);
      // this.sendAttributes()
    },

    sendAttributes(){
      this.$refs.goodsAttributeForm.sendData()
    },

    updateInputs() {
      if (this.goodsStore.goods !== {}){
        const goods = this.goodsStore.goods;
        // console.log("the goods now are: ", goods)
        this.inputData.id = goods.id
        this.inputData.name = goods.name
        this.inputData.description = goods.description
        this.inputData.price = goods.price
        this.inputData.available =
          this.inputData.availableVariants.find(item => item.valueBool === Number(goods.available))
          // this.inputData.availableVariants.find(item => item.valueBool === Number(goods.available)) === undefined ?
          //   this.inputData.availableVariants.find(item => item.valueBool === Number(goods.available)) :
          //   this.inputData.availableVariants.find(item => item.valueBool === Number(goods.available)).valueBool

      }
    }
  },

  watch: {
    "goodsStore.goods": {
      handler(toParams, previousParams) {
        this.updateInputs()
      },
      deep: true
    },
    "goodsStore.category": {
      handler(toParams, previousParams) {
        if (toParams !== {}){
          this.inputData.category = toParams
        }
      },
    }
  },

  mounted() {
    this.updateInputs()
  }

}
</script>

<style scoped>

</style>

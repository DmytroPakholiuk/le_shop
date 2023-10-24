<template>
  <goods-form
    :is-new="true"
    ref="goodsForm"
    @submitData="sendData"
  />
<!--  <v-form>-->
<!--    <v-text-field-->
<!--      name="name"-->
<!--      label="Name"-->
<!--      :rules="inputRules.nameRules"-->
<!--      v-model="inputData.name"-->
<!--    />-->

<!--    <v-textarea-->
<!--      name="description"-->
<!--      label="Description"-->
<!--      v-model="inputData.description"-->
<!--    />-->

<!--    <v-text-field-->
<!--      name="price"-->
<!--      label="Price"-->
<!--      v-model="inputData.price"-->
<!--      :rules="inputRules.priceRules"-->
<!--    />-->

<!--    <v-select-->
<!--      name="available"-->
<!--      label="Is available?"-->
<!--      :items="inputData.availableVariants"-->
<!--      v-model="inputData.available"-->
<!--      item-title="valueText"-->
<!--      item-value="valueBool"-->

<!--    />-->

<!--    <v-autocomplete-->
<!--      name="category_id"-->
<!--      id="category_input"-->
<!--      label="Category"-->
<!--      :items="inputData.categoryVariants"-->
<!--      item-title="name"-->
<!--      item-value="id"-->
<!--      @input="fetchCategories"-->
<!--      v-model="inputData.category"-->
<!--      return-object-->
<!--    />-->

<!--    <v-btn @click="sendData" text="Submit"/>-->
<!--  </v-form>-->
</template>

<script>
import {useAuthStore} from "@/store/auth";
import GoodsForm from "@/components/GoodsForm.vue";
import {useGoodsStore} from "@/store/goods";

export default {
  components: {GoodsForm},
  data: () => ({
    authStore: useAuthStore(),
    goodsStore: useGoodsStore(),
    // goods: {}
  }),
  // data: () => ({
  //   authStore: useAuthStore(),
  //   inputData: {
  //     id: 0,
  //     name: "",
  //     description: "",
  //     price: "",
  //     available: {valueText: "Yes", valueBool: 1},
  //     availableVariants: [
  //       {valueText: "No", valueBool: 0},
  //       {valueText: "Yes", valueBool: 1}
  //     ],
  //     // todo: think how to get such bool values more reusable
  //     category: {id: null, name: null},
  //     categoryVariants: [],
  //     author_id: "",
  //   },
  //
  //   inputRules: {
  //     nameRules: [
  //       value => {
  //         if (value) return true
  //
  //         return 'Name is required.'
  //       }
  //     ],
  //     priceRules: [
  //       value => {
  //         if (value) return true
  //
  //         return 'Price is required.'
  //       },
  //       value => {
  //         if (/^\s*[0-9]+\.?[0-9]{0,2}\s*$/.test(value)){
  //           return true
  //         }
  //
  //         return "Price should be a decimal number, with 2 digits after point delimiter"
  //       }
  //     ],
  //     availableRules: [
  //       value => {
  //         if (value) return true
  //
  //         return 'Availability info is required.'
  //       }
  //     ],
  //   }
  // }),
  methods: {
    sendData(payload){
      console.log(payload)
      let data = payload;
      this.authStore.axios.post( this.authStore.apiUrl + "/api/goods",
        data,
        {
          headers: {
            "Authorization": "Bearer " + this.authStore.accessToken
          }
          // we should include the auth token here. But also better todo send the auth header all the time
        }).then(async resp => {
        let data = resp.data.data
        await this.sendAttributes()

        this.$router.push({path: `/goods/${data.id}`})
      })
    },

    sendAttributes()
    {
      this.$refs.goodsForm.sendAttributes()
    },
    // sendData(){
    //   let data = {
    //     // id: this.inputData.id,
    //     name: this.inputData.name,
    //     description: this.inputData.description,
    //     price: this.inputData.price,
    //     available: this.inputData.available,
    //     category_id: this.inputData.category.id
    //   }
    //   this.authStore.axios.post( this.authStore.apiUrl + "/api/goods",
    //     data,
    //     {
    //     headers: {
    //       "Authorization": "Bearer " + this.authStore.accessToken
    //     }
    //     // we should include the auth token here. But also better todo send the auth header all the time
    //   }).then(resp => {
    //     console.log(resp)
    //     let data = resp.data.data
    //     this.$router.push({ path: `/goods/${data.id}`})
    //   })
    // },

    // fetchCategories(event) {
    //   this.authStore.axios.get(this.authStore.apiUrl + "/api/categories?"
    //     + "per_page=10&"
    //     + "name=" + event.target.value,
    //     {
    //     headers: {
    //       "Authorization": "Bearer " + this.authStore.accessToken
    //     }
    //     // we should include the auth token here. But also better todo send the auth header all the time
    //   }).then(resp => {
    //     console.log(resp.data.data)
    //     this.inputData.categoryVariants = resp.data.data
    //   })
    // }
  },
  name: "GoodsCreateForm"
}
</script>

<style scoped>

</style>

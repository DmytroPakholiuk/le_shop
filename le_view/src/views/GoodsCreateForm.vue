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

    />

    <v-autocomplete
      name="category_id"
      id="category_input"
      label="Category"
      :items="inputData.categoryVariants"
      item-title="name"
      item-value="id"
      @input="getCategories"
      v-model="inputData.category"
      return-object
    />

    <v-btn @click="sendData" text="Submit"/>
  </v-form>
</template>

<script>

import {useAuthStore} from "@/store/auth";

export default {
  data: () => ({
    authStore: useAuthStore(),
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
  methods: {
    sendData(){
      let data = {
        // id: this.inputData.id,
        name: this.inputData.name,
        description: this.inputData.description,
        price: this.inputData.price,
        available: this.inputData.available.valueBool,
        category_id: this.inputData.category.id
      }
      this.authStore.axios.post( this.authStore.apiUrl + "/api/goods", data, {
        headers: {
          "Authorization": "Bearer " + this.authStore.accessToken
        }
        // we should include the auth token here. But also better todo send the auth header all the time
      }).then(resp => {
          console.log(resp)
      })
    },

    getCategories(event) {
      this.authStore.axios.get(this.authStore.apiUrl + "/api/categories?"
        + "per_page=10&"
        + "name=" + event.target.value,
        {
        headers: {
          "Authorization": "Bearer " + this.authStore.accessToken
        }
        // we should include the auth token here. But also better todo send the auth header all the time
      }).then(resp => {
        console.log(resp.data.data)
        this.inputData.categoryVariants = resp.data.data
      })
    }
  },
  name: "GoodsCreateForm"
}
</script>

<style scoped>

</style>

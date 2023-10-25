<template>
  <v-select
    :label="attribute.name"
    :items="availableVariants"
    v-model="value"
    item-title="value"
    item-value="id"

  />
</template>

<script>
import {useAuthStore} from "@/store/auth";
import {useAttributeStore} from "@/store/attribute";

export default {
  name: "AttributeInputDictionary",

  props: {
    attribute: Object
  },

  data: () => ({
    authStore: useAuthStore(),
    attributeStore: useAttributeStore(),
    value: {
      id: "", value: ""
    },
    availableVariants: [],
    inputRules: [
      value => {
        if (this.availableVariants.find(variant => {
          return variant.id === value
        }) != null){
          return true
        }

        return "This attribute has to have value, defined in dictionary"
      }
    ],
  }),

  computed: {
    exportData() {
      const data = {};
      data.id = this.attribute.id;
      data.value = this.value.id;
      data.goods_id = this.attribute.goods_id

      return data;
    }
  },

  watch: {
    value: {
      handler(newValue, oldValue) {
        if (newValue !== undefined) {
          this.attributeStore.attributes[this.attribute.id].value = newValue.id
        }
        // console.log("attribute: ", this.attribute)
        // console.log("value: ", newValue)
      },
      deep: true
    }
  },

  mounted() {
    // this.value = this.availableVariants.find(value => {return value.valueBool == this.attribute.value})
    this.authStore.axios.get(this.authStore.apiUrl + "/api/attributes/" + this.attribute.id + "/dictionary-definitions",
      {
        headers: {
          Authorization: "Bearer " + this.authStore.accessToken
        }
      }
    ).then(resp => {
      this.availableVariants = resp.data.data
      this.value = this.availableVariants.find(value => {
        return typeof this.attribute.value === 'object' ?
          value.id == this.attribute.value.id :
          value.id == this.attribute.value
      })
    });
  }
}
</script>

<style scoped>

</style>

<template>
  <v-select
    :label="attribute.name"
    :items="availableVariants"
    v-model="value"
    item-title="valueText"
    item-value="valueBool"

  />
</template>

<script>
import {useAttributeStore} from "@/store/attribute";

export default {
  name: "AttributeInputBoolean",

  props: {
    attribute: Object
  },

  data: () => ({
    attributeStore: useAttributeStore(),
    value: {
      valueText: "Yes", valueBool: 1
    },
    availableVariants: [
      {
        valueText: "Yes", valueBool: 1
      },
      {
        valueText: "No", valueBool: 0
      }
    ],
    inputRules: [
      value => {
        if ([true, false, "1", "0", 1, 0, ""].includes(value)){
          return true
        }

        return "This attribute is supposed to have a boolean value"
      }
    ],
  }),

  computed: {
    exportData() {
      const data = {};
      data.id = this.attribute.id;
      data.value = this.value.valueBool;
      data.goods_id = this.attribute.goods_id

      return data;
    }
  },

  watch: {
    value: {
      handler(newValue, oldValue) {
        this.attributeStore.attributes[this.attribute.id].value = newValue.valueBool
      },
      deep: true
    }
  },

  mounted() {
    this.value = this.availableVariants.find(value => {
      return typeof this.attribute.value === 'object' ?
       value.valueBool == this.attribute.value.valueBool :
       value.valueBool == this.attribute.value
    })
  }
}
</script>

<style scoped>

</style>

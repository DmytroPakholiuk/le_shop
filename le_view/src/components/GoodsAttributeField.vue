<template>
  <div>
    <component
      :is="attributeValueInputComponent"
      :attribute="attribute"
      ref="attributeField"
    />
  </div>
</template>

<script>
import AttributeInputText from "@/components/attributeInputs/AttributeInputText.vue";
import AttributeInputInteger from "@/components/attributeInputs/AttributeInputInteger.vue";
import AttributeInputFloat from "@/components/attributeInputs/AttributeInputFloat.vue";
import AttributeInputBoolean from "@/components/attributeInputs/AttributeInputBoolean.vue";
import AttributeInputDictionary from "@/components/attributeInputs/AttributeInputDictionary.vue";

export default {
  components: {
    AttributeInputText,
    AttributeInputInteger,
    AttributeInputFloat,
    AttributeInputBoolean,
    AttributeInputDictionary
  },
  data: () => ({
    attributeTypes: {
      0: {
        name: "text",
        component: "AttributeInputText"
      },
      1: {
        name: "integer",
        component: "AttributeInputInteger"
      },
      2: {
        name: "float",
        component: "AttributeInputFloat"
      },
      3: {
        name: "boolean",
        component: "AttributeInputBoolean"
      },
      4: {
        name: "dictionary",
        component: "AttributeInputDictionary"
      }
    }
  }),

  name: "GoodsAttributeField",

  props: {
    attribute: Object
  },

  computed: {
    attributeValueInputComponent(){
      return this.attributeTypes[this.attribute.type].component
    },
  },

  methods: {
  }
}
</script>

<style scoped>

</style>

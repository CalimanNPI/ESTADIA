<template>
  <div class="flex items-center mb-4">
    <input :id="idbox" type="radio" :name="nameRadio" :checked="isChecked" :value="value" @change="$emit('change', $event.target.value)"  class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
    <label :for="idbox" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
       {{label}}
    </label>
  </div>
</template>

<script>
export default {
  model: {
    prop: 'modelValue',
    event: 'change'
  },
  props: {
    "label": { type: String, default: "", required:true },
    "modelValue": { default: "" },
    "value": { type: String, default: undefined },
    "nameRadio": { type: String, default: "", required:true },
    "idbox": { type: String, default: "", required:true },
  },
  computed: {
    isChecked() {
      return this.modelValue == this.value
    }
  }
}
</script>

<template>
  <div class="flex items-center mb-4">
      <input
        class="
          bg-gray-100
          focus:ring-blue-500
          text-blue-600
          border-gray-300
          h-4
          w-4
          rounded
          dark:focus:ring-blue-600 dark:ring-offset-gray-800
          focus:ring-2
          dark:bg-gray-700 dark:border-gray-600
        "
        type="checkbox"
        :checked="isChecked"
        :value="value"
        @change="updateInput"
        :id="idcheckbox"
      />
       <label :for="idcheckbox" class="text-sm ml-3 font-medium text-gray-900 dark:text-gray-300">
      {{ label }}
      <span class="checkmark"></span>
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
    "value": { type: String },
    "modelValue": { default: "" },
    "label": { type: String, required: true},
    "trueValue": { default: true },
    "falseValue": { default: false },
    "idcheckbox":{type: String}
  },
  computed: {
    isChecked() {
      if (this.modelValue instanceof Array) {
        return this.modelValue.includes(this.value)
      }
      // Note that `true-value` and `false-value` are camelCase in the JS
      return this.modelValue === this.trueValue
    }
  },
  methods: {
    updateInput(event) {
      let isChecked = event.target.checked
      if (this.modelValue instanceof Array) {
        let newValue = [...this.modelValue]
        if (isChecked) {
          newValue.push(this.value)
        } else {
          newValue.splice(newValue.indexOf(this.value), 1)
        }
        this.$emit('change', newValue)
      } else {
        this.$emit('change', isChecked ? this.trueValue : this.falseValue)
      }
    }
  }
}
</script>

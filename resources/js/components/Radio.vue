<template>
  <div class="flex items-center mb-4">
    <input
      type="radio"
      :checked="isChecked"
      :value="value"
      @change="$emit('change', $event.target.value)"
      class="
        h-4
        w-4
        border-gray-300
        focus:ring-2 focus:ring-blue-300
        dark:focus:ring-blue-600 dark:bg-gray-700 dark:border-gray-600
      "
    />
    <label
      for="idradio"
      class="text-sm font-medium text-gray-900 ml-2 block dark:text-gray-300"
    >
      {{ label }}
    </label>
  </div>
</template>

<script>
export default {
  model: {
    prop: "modelValue",
    event: "change",
  },
  props: {
    label: { type: String, default: "", required: true },
    modelValue: { default: "" },
    value: { type: String, default: undefined },
  },
  computed: {
    isChecked() {
      return this.modelValue == this.value;
    },
  },
};
</script>

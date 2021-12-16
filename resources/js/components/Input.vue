<template>
  <input
    class="
      shadow-sm
      bg-gray-50
      border border-blue-200 md:border-blue-200 focus:border-blue-500
      border-opacity-75
      text-gray-900
      sm:text-sm
      rounded-lg
      block
      w-full
      p-2.5
      placeholder-gray-500
    "
    required
    :placeholder="placeholder"
    @input="$emit('input', $event.target.value)"
  />
</template>

<script>
export default {
  props: ["modelValue", "placeholder"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>

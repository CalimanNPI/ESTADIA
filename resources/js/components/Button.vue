<template>
  <button
    :type="type"
    :class="`
      text-white
      bg-${color}-500
      hover:bg-${color}-600
      focus:ring-4 focus:ring-${color}-300
      font-medium
      rounded-lg
      text-sm
      px-5
      py-2.5
      text-center
      mr-3
      mb-3
      dark:bg-blue-600 dark:hover:bg-${color}-600 dark:focus:ring-${color}-600
      shadow-md
      transition
      transform
      hover:-translate-y-1
      motion-reduce:transition-none motion-reduce:transform-none`"
  >
    <font-awesome-icon :icon="['far', iconName]" />
    {{ value }}
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "submit",
    },
    value: {
      type: String,
    },
    color: {
      type: String,
    },
    iconName: {
      type: String,
    },
  },
};
</script>

<template>
  <router-link
    :to="link"
    :class="`
        inline-block
        align-baseline
        outline-none
        mr-1 mb-1 px-8 py-3
        bg-transparent
        text-base
        font-bold
        text-${color}-500
        uppercase
        focus:outline-none
        hover:underline`"
    exact
  >
    <font-awesome-icon :icon="['far', iconName]" />{{ value }}</router-link
  >
</template>
<script>
export default {
  props: {
    value: {
      type: String,
    },
    color: {
      type: String,
    },
    link: {
      type: Object,
    },
    iconName: {
      type: String,
    },
  },
};
</script>

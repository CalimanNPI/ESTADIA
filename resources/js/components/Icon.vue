<template>
    <img class="inline object-cover w-8 h-8 rounded-full" :src="img" :alt="value"/>
</template>

<script>
export default {
  props: {
    value: {
      type: String,
    },
    img: {
      type: String,
    },
  },
};
</script>

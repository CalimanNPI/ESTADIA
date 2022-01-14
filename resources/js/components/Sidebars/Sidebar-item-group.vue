<template>
      <li class="items-center"  v-if="$can(gate)">
        <router-link
          :to="path"
           class="text-xs uppercase py-3 font-bold block text-gray-800 hover:text-gray-500"
          exact
        >
            <font-awesome-icon :icon="[icontype, icon]" />
            {{title}}
        </router-link>
      </li>
</template>
<script>
export default {
   props: {
    title: {
      type: String,
      default: "submit",
    },
    path: {
      type: Object,
    },
    icon: {
      type: String,
    },
    icontype: {
      type: String,
    },
    gate: {
      type: String,
    },
  },
};
</script>

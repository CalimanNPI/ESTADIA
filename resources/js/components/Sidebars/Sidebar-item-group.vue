<template>
  <div>
    <hr class="my-4 md:min-w-full" />
    <!-- Heading -->
    <h6
      class="
        md:min-w-full
        text-gray-800 text-xs
        uppercase
        font-bold
        block
        pt-1
        pb-4
        no-underline
      "
    >
      Admin Layout Pages
    </h6>
    <!-- Navigation -->

    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
      <li class="items-center">
        <router-link
          to="/admin/dashboard"
          v-slot="{ href, navigate, isActive }"
        >
          <a
            :href="href"
            @click="navigate"
            class="text-xs uppercase py-3 font-bold block"
            :class="[
              isActive
                ? 'text-blue-500 hover:text-blue-600'
                : 'text-gray-800 hover:text-gray-500',
            ]"
          >
            <i
              class="fas fa-tv mr-2 text-sm"
              :class="[isActive ? 'opacity-75' : 'text-blueGray-300']"
            ></i>
            Dashboard
          </a>
        </router-link>
      </li>
    </ul>
  </div>
</template>
<script>
import { defineComponent } from "@vue/composition-api";

export default defineComponent({
  setup() {},
});
</script>

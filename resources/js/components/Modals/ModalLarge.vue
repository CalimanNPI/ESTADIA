<template>
  <div>
    <button
      class="
        bg-pink-500
        text-white
        active:bg-pink-600
        font-bold
        uppercase
        text-sm
        px-6
        py-3
        rounded
        shadow
        hover:shadow-lg
        outline-none
        focus:outline-none
        mr-1
        mb-1
        ease-linear
        transition-all
        duration-150
      "
      type="button"
      v-on:click="toggleModalLarge()"
    >
      Mis Empresas
    </button>
    <div
      v-if="showModal"
      class="
        overflow-x-hidden overflow-y-auto
        fixed
        inset-0
        z-50
        outline-none
        focus:outline-none
        justify-center
        items-center
        flex
      "
    >
      <div class="relative w-auto my-6 mx-auto max-w-6xl">
        <!--content-->
        <div
          class="
            border-0
            rounded-lg
            shadow-lg
            relative
            flex flex-col
            w-full
            bg-white
            outline-none
            focus:outline-none
          "
        >
          <!--header-->
          <div
            class="
              flex
              items-start
              justify-between
              p-5
              border-b border-solid border-gray-200
              rounded-t
            "
          >
            <h3 class="text-3xl font-semibold">
              {{ Name }}
            </h3>
            <button
              class="
                p-1
                ml-auto
                border-0
                text-black
                float-right
                text-3xl
                leading-none
                font-semibold
                outline-none
                focus:outline-none
              "
              v-on:click="toggleModalLarge()"
            >
              <span
                class="
                  text-gray-800
                  h-6
                  w-6
                  text-2xl
                  block
                  outline-none
                  focus:outline-none
                "
              >
                ×
              </span>
            </button>
          </div>
          <!--body-->
          <div class="relative p-6">
            <slot />
          </div>
          <!--footer-->
          <div
            class="
              flex
              items-center
              justify-end
              p-6
              border-t border-solid border-blueGray-200
              rounded-b
            "
          >
            <button
              class="
                text-red-500
                background-transparent
                font-bold
                uppercase
                px-6
                py-2
                text-sm
                outline-none
                focus:outline-none
                mr-1
                mb-1
                ease-linear
                transition-all
                duration-150
              "
              type="button"
              v-on:click="toggleModalLarge()"
            >
              Close
            </button>
            <!--  <button class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button" v-on:click="toggleModal()">
              Save Changes
            </button> -->
          </div>
        </div>
      </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
    },
  },
  data() {
    return {
      showModal: false,
    };
  },
  methods: {
    toggleModalLarge: function () {
      this.showModal = !this.showModal;
    },
  },
};
</script>

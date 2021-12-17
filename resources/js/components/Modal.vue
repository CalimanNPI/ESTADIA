<template>
  <div
    id="overlay"
    class="
      fixed
      left-0
      right-0
      z-50
      items-center
      justify-center
      hidden
      bg-black bg-opacity-50
    "
  >
    <div class="relative w-full h-full max-w-md px-4 md:h-auto">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div
          class="
            flex
            items-start
            justify-between
            p-5
            border-b
            rounded-t
            dark:border-gray-600
          "
        >
          <h3
            class="
              text-xl
              font-semibold
              text-gray-900
              lg:text-2xl
              dark:text-white
            "
          >
            {{value}}
          </h3>
          <svg
            class="h-6 w-6 cursor-pointer p-1 hover:bg-gray-300 rounded-full"
            id="close-modal"
            fill="currentColor"
            viewBox="0 0 20 20"
          >
            <path
              fill-rule="evenodd"
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
            ></path>
          </svg>
        </div>
        <!-- Modal body -->
        <div class="p-6 space-y-6">
          <slot />
        </div>
        <!-- Modal footer -->
        <div
          class="
            flex
            items-center
            p-6
            space-x-2
            border-t border-gray-200
            rounded-b
            dark:border-gray-600
          "
        ></div>
      </div>
    </div>
  </div>
</template>
<script>

export default {
  props: {
    value: {
      type: String,
    },
  },
};
window.addEventListener("DOMContentLoaded", () => {
  const overlay = document.querySelector("#overlay");
  const btn = document.querySelector("#btn");
  const closeBtn = document.querySelector("#close-modal");

  const toggleModal = () => {
    overlay.classList.toggle("hidden");
    overlay.classList.toggle("flex");
  };

  btn.addEventListener("click", toggleModal);

  closeBtn.addEventListener("click", toggleModal);
});
</script>


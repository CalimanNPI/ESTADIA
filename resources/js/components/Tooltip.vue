<template>
  <div
    class="
      text-sm
      mt-2
      bg-gray-600
      text-gray-100
      px-1
      absolute
      rounded
      bg-opacity-50
      shadow-xl
      hidden
    "
    id="tooltip"
    role="tooltip"
  ></div>
</template>
<script>
window.addEventListener("DOMContentLoaded", () => {
  const tool = document.querySelector("#tool");
  const tooltip = document.querySelector("#tooltip");

  tooltip.innerHTML = tool.dataset.tooltipText;

  tool.addEventListener("mouseenter", () => {
    tooltip.classList.remove("hidden");
  });

  tool.addEventListener("mouseleave", () => {
    tooltip.classList.add("hidden");
  });
});
</script>

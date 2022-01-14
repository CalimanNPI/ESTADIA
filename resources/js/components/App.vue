<template>
  <div>
    <Sidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <Navbar />
      <Header />
      <div class="px-4 md:px-10 mx-auto w-full -m-24">
        <router-view></router-view>

        <Footer />
      </div>
    </div>
  </div>
</template>
<script>
import Footer from "./Footers/Footer.vue";
import Header from "./Headers/HeaderStats.vue";
import Navbar from "./Navbars/Navbar.vue";
import Sidebar from "./Sidebars/Sidebar.vue";
export default {
  components: {
    Footer,
    Header,
    Navbar,
    Sidebar,
  },
};
</script>


<template>
  <nav
    class="
      md:left-0
      md:block
      md:fixed
      md:top-0
      md:bottom-0
      md:overflow-y-auto
      md:flex-row
      md:flex-nowrap
      md:overflow-hidden
      shadow-xl
      bg-white
      flex flex-wrap
      items-center
      justify-between
      relative
      md:w-64
      z-10
      py-4
      px-6
    "
  >
    <div
      class="
        md:flex-col md:items-stretch md:min-h-full md:flex-nowrap
        px-0
        flex flex-wrap
        items-center
        justify-between
        w-full
        mx-auto
      "
    >
      <!-- Toggler -->
      <button
        class="
          cursor-pointer
          text-black
          opacity-50
          md:hidden
          px-3
          py-1
          text-xl
          leading-none
          bg-transparent
          rounded
          border border-solid border-transparent
        "
        type="button"
        v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')"
      >
        <font-awesome-icon :icon="['fas', 'bars']" />
      </button>
      <!-- Brand -->
      <router-link
        class="
          md:block
          text-left
          md:pb-2
          text-gray-900
          mr-0
          inline-block
          whitespace-nowrap
          text-sm
          uppercase
          font-bold
          p-4
          px-0
        "
        :to="{name: 'Home'}"
      >
       <font-awesome-icon :icon="['fas', 'home']" /> {{ name }}
      </router-link>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <UserDropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="
          md:flex
          md:flex-col
          md:items-stretch
          md:opacity-100
          md:relative
          md:mt-4
          md:shadow-none
          shadow
          absolute
          top-0
          left-0
          right-0
          z-40
          overflow-y-auto overflow-x-hidden
          h-auto
          items-center
          flex-1
          rounded
        "
        v-bind:class="collapseShow"
      >
        <!-- Collapse header -->
        <div
          class="
            md:min-w-full md:hidden
            block
            pb-4
            mb-4
            border-b border-solid border-gray-200
          "
        >
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <router-link
                class="
                  md:block
                  text-left
                  md:pb-2
                  text-gray-800
                  mr-0
                  inline-block
                  whitespace-nowrap
                  text-sm
                  uppercase
                  font-bold
                  p-4
                  px-0
                "
                :to="{name: 'Home'}"
              >
                  <font-awesome-icon :icon="['fas', 'home']" /> {{ name }}
              </router-link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button
                type="button"
                class="
                  cursor-pointer
                  text-black
                  opacity-50
                  md:hidden
                  px-3
                  py-1
                  text-xl
                  leading-none
                  bg-transparent
                  rounded
                  border border-solid border-transparent
                "
                v-on:click="toggleCollapseShow('hidden')"
              >
                <font-awesome-icon :icon="['fas', 'times']" />
              </button>
            </div>
          </div>
        </div>

        <div v-for="sidebarLink in sidebarLinks" :key="sidebarLink.gate">
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
            {{ sidebarLink.title }}
          </h6>
          <!-- Navigation -->

          <ul
            class="md:flex-col md:min-w-full flex flex-col list-none"
            v-if="$can(sidebarLink.gate)"
          >
            <Sidebar
              v-for="link in sidebarLink.children"
              :key="link.gate"
              :title="link.title"
              :path="link.path"
              :icon="link.icon"
              :icontype="link.icontype"
              :gate="link.gate"
            />
          </ul>
        </div>
      </div>
    </div>
  </nav>
</template>
); }

<script>
import UserDropdown from "../Dropdowns/UserDropdown.vue";
import Sidebar from "./Sidebar-item-group.vue";

export default {
  data() {
    return {
      collapseShow: "hidden",
      name: "Dash",
      ability: [],
      sidebarLinks: [
        {
          title: "User management",
          gate: "user_management_access",
          children: [
            {
              title: "Permissions",
              icon: "user-cog",
              icontype: "fas",
              path: { name: "permission.index" },
              gate: "permission_index",
            },
            {
              title: "Roles",
              icon: "user-tag",
              icontype: "fas",
              path: { name: "role.index" },
              gate: "role_index",
            },
            {
              title: "User",
              icon: "user-tie",
              icontype: "fas",
              path: { name: "user.index" },
              gate: "user_index",
            },
          ],
        },
        {
          title: "Company management",
          gate: "company_management_access",
          children: [
            {
              title: "Company",
              icon: "building",
              icontype: "fas",
              path: { name: "empresa.index" },
              gate: "empresa_index",
            },
            {
              title: "Create FIEL",
              icon: "folder",
              icontype: "fas",
              path: { name: "empresa.fiel" },
              gate: "empresa_fiel",
            },
          ],
        },
        {
          title: "CFDIs processing",
          gate: "web_service",
          children: [
            {
              title: "CFDIs Download",
              icon: "file-download",
              icontype: "fas",
              path: { name: "procesamiento" },
              gate: "web_service",
            },
            {
              title: "Reports",
              icon: "chart-area",
              icontype: "fas",
              path: { name: "reports" },
              gate: "reports",
            },
            {
              title: "Processing",
              icon: "laptop-code",
              icontype: "fas",
              path: { name: "readZip" },
              gate: "read_zip",
            },
          ],
        },
      ],
    };
  },
  mounted() {
    this.getPermissions();
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },
    getPermissions() {
      axios
        .get("/api/ability")
        .then((response) => {
          console.log(response.data);
          //   this.ability.update([
          //       {subject:'all', actions: response.data}
          //   ])
        })
        .catch((err) => {
          this.$swal({
            icon: "error",
            title: "Se produjo un Error",
            text: "error en : " + err,
          });
        });
    },
  },
  components: {
    UserDropdown,
    Sidebar,
  },
};
</script>


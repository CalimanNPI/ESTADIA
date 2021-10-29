<template>
  <div class="container w-full md:w-4/5 xl:w-4/5 mx-auto px-2">
    <div id="recipients" class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
      <table
        id="table"
        class="stripe hover"
        style="width: 100%; padding-top: 1em; padding-button: 1em"
      >
        <thead class="bg-indigo-400 bg-opacity-100 text-white">
          <tr>
            <th>Título</th>
            <th>Contenido</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="blog in blogs" :key="blog.id">
            <td>{{ blog.titulo }}</td>
            <td>{{ blog.contenido }}</td>
            <td>
              <router-link
                :to="{ name: 'blog.edit', params:{ id:blog.id } }"
                class="
                  shadow
                  bg-green-500
                  hover:bg-green-400
                  focus:shadow-outline
                  focus:outline-none
                  text-white
                  font-bold
                  py-1
                  px-2
                  rounded
                "
                >Editar</router-link
              >
              <a
                href="#"
                @click="delete_blog(blog.id)"
                class="
                  shadow
                  bg-red-500
                  hover:bg-red-400
                  focus:shadow-outline
                  focus:outline-none
                  text-white
                  font-bold
                  py-1
                  px-2
                  rounded
                "
                >Borar</a
              >
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      blogs: [],
    };
  },
  mounted() {
    this.getResults();
  },
  methods: {
    getResults() {
      axios
        .get("/api/blogs")
        .then((response) => {
          this.blogs = response.data.data;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    delete_blog(id) {
      axios
        .delete("/api/blogs/" + id)
        .then((result) => {
          this.$swal({ icon: "sucess", title: "Delete successfully" });
           this.getResults();
        })
        .catch((err) => {
          this.$swal( {icon: 'error', title:'Error Happened'});
        });
    },
  },
};
</script>
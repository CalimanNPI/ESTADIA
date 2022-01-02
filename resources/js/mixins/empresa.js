module.exports = {
    computed: {
        isSelectedEmpresa() {
            return !! this.$cookies.get("currentEmpresa");
        }
        //<div v-if="isSelectedEmpresa">{{currentUser.name}}</div>
    }
};

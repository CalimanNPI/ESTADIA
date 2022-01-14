let modal = false;
module.exports = {
    computed: {
        toggleModalLarge() {
            return (modal = !modal);
        },
        toggleModal() {
            return (modal = !modal);
        },
        showModal() {
            return modal;
        }

        //<div v-if="isSelectedEmpresa">{{currentUser.name}}</div>
    }
};

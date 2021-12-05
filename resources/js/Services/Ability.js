import { defineAbility } from "@casl/ability";


export default defineAbility((can, cannot) => {
    can("permission_index", "Permission");
    can("permission_create", "Permission");
    can("permission_edit", "Permission");
    can("permission_destroy", "Permission");

    can("role_index", "Role");
    can("role_create", "Role");
    can("role_edit", "Role");
    can("role_destroy", "Role");

    can("user_index", "User");
    can("user_create", "User");
    can("user_edit", "User");
    can("user_destroy", "User");

    can("empresa_index", "Empresa");
    can("empresa_create", "Empresa");
    can("empresa_edit", "Empresa");
    can("empresa_destroy", "Empresa");

    can("web_service", "User");
});


// export default (store) => {
//     const ability = store.getters.ability

//     ability.update(store.state.rules)

//     return store.subscribe((mutation) => {
//       switch (mutation.type) {
//       case 'createSession':
//         ability.update(mutation.payload.rules)
//         break
//       case 'destroySession':
//         ability.update([{ actions: 'read', subject: 'all' }])
//         break
//       }
//     })
//   }

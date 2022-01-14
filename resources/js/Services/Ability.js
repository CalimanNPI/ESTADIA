import { defineAbility } from "@casl/ability";


export default defineAbility((can, cannot) => {
    can("user_management_access");
    can("company_management_access");


    can("permission_index");
    can("permission_create");
    can("permission_edit");
    can("permission_destroy");

    can("role_index");
    can("role_create");
    can("role_edit");
    can("role_destroy");

    can("user_index");
    can("user_create");
    can("user_edit");
    can("user_destroy");

    can("empresa_index");
    can("empresa_create");
    can("empresa_edit");

    can("empresa_fiel");

    can("web_service");
    can("reports");
    can("read_zip");
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

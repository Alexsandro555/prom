export default {
    namespaced: true,
    state: {
        active: false,
        openRegistration: false,
        isAdmin: localStorage.getItem("isAdmin") === "true"? true: false,
        isAdminView: false
    },
    actions: {
        active({ commit }) {
            commit('ACTIVE')
        },
        disactive({ commit }) {
            commit('DISACTIVE')
        },
        admin({commit}) {
            commit('ADMIN')
        },
        adminView({commit}) {
            commit('ADMIN_VIEW')
        },
        disableAdminView({commit}) {
            commit('DISABLE_ADMIN_VIEW')
        },
        disableAdmin({commit}) {
            commit('DISABLE_ADMIN')
        },
        registration({commit}) {
            commit('REGISTRATION')
        },
        disableRegistration({commit}) {
            commit('DISABLE_REGISTRATION')
        }
     },
    getters: {
        getAdmin(state) {
            return state.isAdmin
        }
    },
    mutations: {
        ACTIVE : (state) => {
            state.active = true
        },
        DISACTIVE: (state) => {
            state.active = false
        },
        ADMIN: (state) => {
            state.isAdmin = true
        },
        ADMIN_VIEW: (state) => {
            state.isAdminView = true
        },
        DISABLE_ADMIN_VIEW: (state) => {
            state.isAdminView = false
        },
        DISABLE_ADMIN: (state) => {
            state.isAdmin = false
        },
        REGISTRATION: (state) => {
            state.openRegistration = true
        },
        DISABLE_REGISTRATION: (state) => {
            state.openRegistration = false
        }
    }
}
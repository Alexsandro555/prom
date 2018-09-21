export default {
    namespaced: true,
    state: {
        messages: {}
    },
    actions: {
        init({ commit, rootState, dispatch}) {
            axios.interceptors.response.use(response => {
                    return response;
                },
                error => {
                    console.log(error)
                    let errorType = error.response.status
                    if(errorType == 419) {
                        setTimeout(() => {document.location.href = '/'},2000)
                    }
                    if(errorType == 422) {
                        let errors = error.response.data.errors
                        if(errors) {
                            for(let field in errors) {
                                commit('INIT', {field, errors})
                            }
                        }
                    }
                    else {
                        swal(errorType.toString(), error.response.data.message, "error");
                    }
                    return Promise.reject(error.response);
                })
        },
        resetError({commit}) {
            commit('RESET_ERROR')
        }
    },
    getters: {},
    mutations: {
        INIT : (state, payload) => {
            let error = [];
            error.push(payload.errors[payload.field])
            state.messages[payload.field] = error
        },
        RESET_ERROR: (state) => {
            state.messages = {}
        }
    }
}
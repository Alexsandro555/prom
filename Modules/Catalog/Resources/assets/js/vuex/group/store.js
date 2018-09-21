import module_actions from './actions.js'
import standart_actions from '../../../../../../../resources/assets/js/vuex/actions.js'
import mutations from './mutations.js'
import module_getters from './getters.js'

var default_actions = {
    init({ dispatch, commit, getters, rootGetters }) {
    },
}

var actions=Object.assign({}, module_actions, standart_actions)
var getters=Object.assign({}, module_getters)

const state = {
    name: 'group',
    items: {},
    fields: [],
    model: 'Modules\\Catalog\\Entities\\Group'
}

const module = {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
}

export default module;
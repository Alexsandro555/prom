import {setFields} from "../../../../../../../../resources/assets/js/store/actions"
import module_actions from './actions'

const actions = Object.assign({},module_actions,setFields)

export default {
    namespaced: true,
    state: {
        name: 'product',
        items: {},
        fields: [],
        typeFiles: ['image-product'],
        model: 'Modules\\Catalog\\Entities\\Product',
        attributes: []
    },
    getters: {
        typeProduct: state => {
            return state.items.type_product
        }
    },
    actions,
    mutations: {
        SET_FIELDS: (state, payload) => {
            for(let key in payload) {
                let obj = {}
                obj[key] = null;
                state.items = Object.assign({},state.items, obj)
            }
            state.fields = payload
        },
        SET_ITEM: (state, payload) => {
            state.items = Object.assign({},state.items, payload)
        },
        FILTER_LIST_PRODUCERS: (state, payload) => {

        },
        UPDATE_RELATIONS: (state, payload) => {
            // при выборе типа продукта у производителя и линейки обновляется список в соответствии с отношениями
            for(let key in payload) {
                if(key === 'producer' || key === 'type_product') return 1;
                if(state.fields[key].relations) {
                    state.fields[key].relations.forEach(relation => {
                        relation = relation.substr(0,relation.length-1)
                        if(state.fields[relation]) {
                            let keyItem = payload[key]
                            state.fields[key].items.forEach(item => {
                                if(item.id == keyItem) {
                                    state.fields[relation].items = item[relation+'s']
                                }
                            })
                        }
                    })
                }
            }
        },
        FILL: (state, payload) => {
            if (!payload) {
                console.log('warning!')
            }
            // очищаем предыдущее состояние
            for(let key in state.items) {
                state.items[key] = null
            }
            for(let key in payload) {
                if(state.items.hasOwnProperty(key)) {
                    if(typeof payload[key] === "object" && payload[key] !== null) {
                        //commit('UPDATE_RELATIONS',{key: payload[key]['id']})
                        state.items[key] = payload[key]['id']
                    }
                    else {
                        state.items[key] = payload[key]
                    }
                }
            }
        },
        SET_ATTRIBUTES: (state, payload) => {
            state.attributes = payload
        },
        RESET_ATTRIBUTES: (state) => {
            state.attributes = []
        }
    }
}
export default {
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
}
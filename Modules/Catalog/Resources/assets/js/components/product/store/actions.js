export default {
    updateRelations({commit},data) {
        let obj = {'type_product': data}
        commit('UPDATE_RELATIONS',obj)
    },
    updateItem({commit}, objField) {
        commit('SET_ITEM',objField)
        commit('UPDATE_RELATIONS', objField)
    },
    filterListProducers({commit},typeProduct) {
        commit('FILTER_LIST_PRODUCERS,typeProduct')
    },
    create({commit}) {
        return new Promise((resolve, reject) => {
            // создание нового продукта с значениями по-умолчанию
            axios.get('/catalog/create').then(response => {
                commit('FILL',response.data)
                resolve()
            }).catch(error => {
                console.log(error)
                reject(error)
            });
        })
    },
    update({commit},id) {
        return new Promise((resolve, reject) => {
            axios.get('/catalog/edit/'+id, {}).then(response => {
                commit('FILL',response.data)
                resolve()
            }).catch(error => {
                console.log(error)
                reject(error)
            });
        })

    },
    attributes({commit},id) {
        axios.get('/catalog/attributes/'+id, {}).then(response => {
            let attributes = [];
            let productAttributes = response.data;
            axios.get('/catalog/attribute-values/'+id).then(res => {
                productAttributes.forEach(productAttribute => {
                    let filtered = res.data.filter(item => item["id"] === productAttribute["id"]);
                    attributes.push({attribute_id: productAttribute["id"], title: productAttribute["title"], value: filtered.length !== 0? filtered[0]["pivot"]["value"]:"", group_id: filtered.length !== 0?filtered[0]["pivot"]["group_id"]:""})
                });
                commit('SET_ATTRIBUTES',attributes)
            }).catch(error => {
                console.log(error);
            })
        }).catch(error => {
            console.log(error)
        })
    },
    resetAttributes({commit}) {
        commit('RESET_ATTRIBUTES')
    }
}
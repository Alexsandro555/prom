const setFields = {
    setFields : ({ commit, state }) => {
        return new Promise((resolve, reject) => {
            axios.get('/initializer/fields/'+state.name).then(response => {
                commit('SET_FIELDS',response.data)
                resolve()
            }).catch(err => {
                console.log(err)
                reject(error)
            })
        })
    }
}

export { setFields };
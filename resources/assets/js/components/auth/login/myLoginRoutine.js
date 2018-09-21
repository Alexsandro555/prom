const myLoginRoutine = user => new Promise ((resolve, reject) => {
    axios({url: '/login', data: user, method: 'POST'})
        .then(resp => {
            //console.log(this.$store)
            //this.$router.push('admin')
            //this.$store.dispatch('auth/admin')
            //this.$store.dispatch('auth/disactive')
            resolve(resp)
        }).catch(err => {
            localStorage.removeItem('user-token')
            reject(err)
        })
})

export {myLoginRoutine};
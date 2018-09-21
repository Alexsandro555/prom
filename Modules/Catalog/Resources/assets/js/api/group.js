import axios from "axios/index"

export const groupApi = {
    save(data) {
        return new Promise((resolve, reject) => {
            axios.patch('/catalog/group', data).then(response => console.log('work') ).then(response => {
                resolve()
            }).catch(error => {
                reject(error)
            })
        })
    }
}
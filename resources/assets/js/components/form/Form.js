import {Errors} from './Errors'

class Form {

    constructor(data) {
        this.originalData = data;
        for(let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }

    reset() {
        for(let field in this.originalData) {
            this[field] = '';
        }
    }

    data() {
        /*let data = Object.assign({}, this);
        delete data.originalData;
        delete data.errors;*/
        let data = {};
        for(let property in this.originalData) {
            data[property] = this[property];
        }
        return data;
    }

    submit(requestType, url) {
        return new Promise((resolve,reject) => {
            axios[requestType](url, this.data()).then(response => {
                this.onSuccess(response.data);
                resolve(response.data);
            }).catch(errors => {
                this.onFail(errors.response.data.errors);
                reject(errors.response.data.errors);
            });
        });
    }

    onSuccess(data) {
        this.errors.clear();
        this.reset();
    }

    onFail(errors) {
        this.errors.record(errors);
    }
}

export {Form}
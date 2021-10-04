export default class Purchase {
    static store(form){
        return window.axios.post('/purchases', new FormData(form))
    }

    static get(params = {}){
        return window.axios.get('/purchases', {
            params: params
        })
    }
}
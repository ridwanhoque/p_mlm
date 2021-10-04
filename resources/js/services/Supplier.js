export default class Supplier{

    static get(query = { all: true }){
        return window.axios.get('/suppliers', {
            params: query
        })
    }
}
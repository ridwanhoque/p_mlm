export default class Order {
    static get(params){
        return window.axios.get('/orders', {
            params
        })
    }
}
export default class Product {
    static get(slug){
        return window.axios.get(`/products/${slug}`, {
            params: {
                ajax: true
            }
        })
    }

    static joining(){
        return window.axios.get('/portal/products', {
            params: {
                joining: '1',
                all: '1'
            }
        })
    }
}
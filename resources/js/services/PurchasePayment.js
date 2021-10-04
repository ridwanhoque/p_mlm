export default class PurchasePayment {
    static get(purchase){
        return window.axios.get(`/purchases/${purchase}/payments`)
    }

    static store(purchase, form){
        return window.axios.post(`/purchases/${purchase}/payments`, new FormData(form))
    }
}
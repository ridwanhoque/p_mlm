export default class WalletPayment {
    static get(){
        return window.axios.get('/wallets')
    }
}
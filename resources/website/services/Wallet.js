
export default class Wallet {
    static cashIn(form){
        return window.axios.post('/portal/wallet/cash-in', new FormData(form)).then(() => {
            form.reset()
        })
    }
}
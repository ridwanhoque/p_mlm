export default class CommissionHand {
    static get(params){
        return window.axios.get('/commission-hands', {
            params
        })
    }

    static create(form){
        return window.axios.post('/commission-hands', new FormData(form)).then(() => {
            $('.create-modal').modal('hide');
            form.reset()
        })
    }
}
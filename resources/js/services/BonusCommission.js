export default class BonusCommission {
    static get(){
        return window.axios.get('/bonus-commissions')
    }

    static create(form){
        return window.axios.post('/bonus-commissions', new FormData(form)).then(() => {
            $('.create-modal').modal('hide');
            form.reset();
        })
    }
}
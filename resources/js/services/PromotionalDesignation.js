export default class PromotionalDesignation {
    static get(){
        return window.axios.get('/promotional-designations')
    }

    static create(form){
        return window.axios.post('/promotional-designations', new FormData(form)).then(() => {
            form.reset();
            $('.create-modal').modal('hide');
        })
    }
}
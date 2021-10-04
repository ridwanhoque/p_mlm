export default class Profile {

    static update(form){
        return window.axios.post('/portal/profile', new FormData(form))
    }

    static updatePassword(form){
        return window.axios.post('/password', new FormData(form)).then(() => {
            form.reset()
        })
    }

    static upgrade(obj){
        return window.axios.post('/portal/upgrade-membership', obj)
    }
}
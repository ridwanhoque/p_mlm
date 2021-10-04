export default class SiteOption {

    constructor(){
        this.options = {}

        this.getAll()
    }

    getAll(){
        return window.axios.get('/options').then(({ data }) => {
            this.options = data.data
        })
    }
    static update(form){
        return window.axios.post('/options', new FormData(form))
    }

    get(optionName, defaultName){
        if(this.options.hasOwnProperty(optionName)){

            return this.options[optionName]['option_value']
        }

        return  defaultName
    }

    has(key){
        if(this.options.hasOwnProperty(key) && this.options[key]['option_value']){
            return true;
        }
        return false;
    }
}
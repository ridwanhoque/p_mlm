<template>
    <div>
        <div class="form-group" v-for="(category, index) in categories" :key="index">
            <label for="category">{{ 'Sub '.repeat(index) }}Category</label>
            <select required @change="getChildCategories" :data-key="index" class="form-control" name="categories[]" id="category">
                <option value="">Select category name</option>
                <option v-for="cat in category" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            errors: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        },
        data(){
            return {
                categories: []
            }
        },
        mounted() {
            this.getCategories('', (data) => {
                this.categories.push(data.data)
            })
        },
        methods: {
            getCategories(parent = '', callback){
                window.axios.get('/categories', {
                    params: {
                        parent_id: parent,
                        all: true
                    }
                }).then(({ data }) => {
                    callback(data)
                })
            },
            getChildCategories(event){
                let elem = event.target

                if(elem.value){
                    this.getCategories(elem.value, (data) => {

                        this.categories.forEach((c, index) => {
                            if(index > parseInt(elem.dataset.key)){
                                this.categories.splice(index, 1)
                            }
                        })

                        if(data.data.length){
                            this.categories.push(data.data)
                        }
                    })
                }
            },
        }
    }
</script>
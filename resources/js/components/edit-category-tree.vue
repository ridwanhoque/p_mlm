<template>
    <div>
        <div class="form-group" v-for="(category, index) in categories" :key="index">
            <label>{{ 'Sub '.repeat(index) }}Category</label>
            <select required @change="getChildCategories" :data-key="index" class="form-control categories" name="categories[]">
                <option value="">Select category name</option>
                <option v-for="cat in category" :selected="getDefaultCategoryId(index) == cat.id ? true : false" :value="cat.id">{{ cat.name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            defaultCategories: {
                type: Array,
                default: function () {
                    return []
                }
            },
            errors: {
                type: Object,
                default: function () {
                    return {}
                }
            }
        },
        data(){
            return {
                categories: [],
            }
        },
        mounted(){
            this.$nextTick(() => {
                this.updateCategories(this.defaultCategories)

            })
        },
        methods: {
            getCategories(parent = ''){
                return new Promise((resolve, reject) => {
                    window.axios.get('/categories', {
                        params: {
                            parent_id: parent,
                            all: true
                        }
                    }).then(({ data }) => {
                        resolve(data)
                    }).catch((error) => {
                        reject(error)
                    })
                })
            },
            getChildCategories(event){
                let elem = event.target

                if(elem.value){
                    this.getCategories(elem.value).then((data) => {

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
            async updateCategories(categories){
                for(let category of categories){
                    await this.getCategories(category.parent_id).then(({ data } ) => {
                        this.categories.push(data)
                    })
                }
            },
            getDefaultCategoryId(index){
                if(this.defaultCategories[index]){
                    return this.defaultCategories[index].id
                }
                return undefined
            }
        }
    }
</script>
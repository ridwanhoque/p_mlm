<template>
    <div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" v-model="emi_available" name="emi_available" value="1" class="custom-control-input" id="emi_available">
                <label class="custom-control-label" for="emi_available">EMI Available</label>
            </div>
        </div>
        <div v-if="emi_available" class="card mb-2">
            <div class="card-header">
                Emi Options
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="cash_price">Cash Price</label>
                    <input type="text" class="form-control" readonly :value="cashPrice" id="cash_price">
                </div>
                <div class="form-group">
                    <label for="price">EMI Price</label>
                    <input type="text" v-model="emiData.price" :class="{ 'is-invalid': errors.hasOwnProperty('price')}" name="price" class="form-control" id="price">
                    <p class="invalid-feedback" v-if="errors.hasOwnProperty('price')">{{ errors.price[0] }}</p>
                </div>
                <div class="form-group">
                    <label for="installment_duration">Installment</label>
                    <input type="text" v-model="emiData.installment_duration" :class="{ 'is-invalid': errors.hasOwnProperty('installment_duration')}" class="form-control" name="installment_duration" id="installment_duration" placeholder="Example: 6 Months">
                    <p class="invalid-feedback" v-if="errors.hasOwnProperty('installment_duration')">{{ errors.installment_duration[0] }}</p>
                </div>
                <div class="form-group">
                    <label for="installment_interval">Installment Interval</label>
                    <div class="input-group">
                        <input type="text" v-model="emiData.installment_interval" :class="{ 'is-invalid': errors.hasOwnProperty('installment_interval')}" v-selected name="installment_interval" class="form-control" id="installment_interval">
                        <div class="input-group-append">
                            <span class="input-group-text">Days</span>
                        </div>
                        <p class="invalid-feedback" v-if="errors.hasOwnProperty('installment_interval')">{{ errors.installment_interval[0] }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="number_of_installment">Number Of Installment</label>
                    <input type="text" v-model="emiData.number_of_installment" v-selected :class="{ 'is-invalid': errors.hasOwnProperty('number_of_installment')}" name="number_of_installment" class="form-control" id="number_of_installment">
                    <p class="invalid-feedback" v-if="errors.hasOwnProperty('number_of_installment')">{{ errors.number_of_installment[0] }}</p>
                </div>

                <div class="row mb-2" v-for="(installment, index) in emiData.installments">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label :for="`installment-name-${(index + 1)}`">Installment Name {{ (index + 1) }}</label>
                            <input type="text" v-selected v-model="installment.name" :name="`installments[${index}][name]`" :class="{ 'is-invalid': errors.hasOwnProperty(`installments.${index}.name`)}" class="form-control" :id="`installment-name-${(index + 1)}`">
                            <p class="invalid-feedback" v-if="errors.hasOwnProperty(`installments.${index}.name`)">{{ errors[`installments.${index}.name`][0] }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label :for="`installment-number-${(index + 1)}`">Installment Amount {{ (index + 1) }}</label>
                            <input type="text" v-selected v-model="installment.installment" :name="`installments[${index}][installment]`" :class="{ 'is-invalid': errors.hasOwnProperty(`installments.${index}.installment`)}" class="form-control" :id="`installment-number-${(index + 1)}`">
                            <p class="invalid-feedback" v-if="errors.hasOwnProperty(`installments.${index}.installment`)">{{ errors[`installments.${index}.installment`][0] }}</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label :for="`installment-commission-${(index + 1)}`">Commission {{ (index + 1) }}</label>
                            <input type="text" v-selected v-model="installment.commission" :name="`installments[${index}][commission]`" :class="{ 'is-invalid': errors.hasOwnProperty(`installments.${index}.commission`)}" :id="`installment-commission-${(index + 1)}`" class="form-control">
                            <p class="invalid-feedback" v-if="errors.hasOwnProperty(`installments.${index}.commission`)">{{ errors[`installments.${index}.commission]`][0] }}</p>
                        </div>
                        <div class="text-right">
                            <button type="button" @click="addEmi" v-if="index === (emiData.installments.length - 1)" class="btn btn-primary btn-xs">Add More</button>
                            <button type="button" @click="emiData.installments.splice(index, 1)" v-if="index" class="btn btn-danger btn-xs">Remove</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="installment_comments">Comments</label>
                    <textarea rows="4" v-model="emiData.comments" :class="{ 'is-invalid': errors.hasOwnProperty('installment_comments')}" name="installment_comments" class="form-control" id="installment_comments"></textarea>
                    <p class="invalid-feedback" v-if="errors.hasOwnProperty('installment_comments')">{{ errors.installment_comments[0] }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            emi: {
                type: Object,
                default: function () {
                    return {}
                }
            },
            cashPrice: {
                type: Number,
                default: 0
            },
            emiAvailable: {
                type: [Boolean, Number],
                default: false
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
                emi_available: false,
                emiData: {
                    installments: [{
                        installment: 0,
                        commission: 0
                    }]
                }
            }
        },
        mounted() {
            this.emi_available = this.emiAvailable

            if(this.emi){
                this.emiData = this.emi
            }
        },
        methods: {
            addEmi(){
                this.emiData.installments.push({
                    installment: 0,
                    commission: 0
                })
            }
        }
    }
</script>
<template>
    <div>
        <div class="app-title">
            <div>
                <h1><i class="fa fa-cog"></i> Commission Configuration</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <app-loader/>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form @submit.prevent="update">
                                    <div class="form-group">
                                        <label for="general-commission">General Commission</label>
                                        <input type="text" :value="option.get('general_commission')" name="text[general_commission]" class="form-control" id="general-commission">
                                    </div>
                                    <div class="form-group">
                                        <label for="minimum-upgrade-amount">Minimum Upgrade Amount</label>
                                        <input type="text" :value="option.get('minimum_upgrade_amount', 0)" name="text[minimum_upgrade_amount]" class="form-control" id="minimum-upgrade-amount">
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import SiteOption from "../../services/Option";

    export default {
        data(){
            return {
                option: new SiteOption()
            }
        },
        methods: {
            update({ target }){
                SiteOption.update(target)
            }
        }
    }
</script>
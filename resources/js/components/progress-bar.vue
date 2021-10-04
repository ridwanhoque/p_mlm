<template>
    <div class="progress" v-if="percentage > 0">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: `${percentage}%`}" :aria-valuenow="percentage" aria-valuemin="0" aria-valuemax="100">{{ percentage }} %</div>
    </div>
</template>
<script>
    export default {
        props: {
            percentage: {
                default: 0,
                type: Number,
                required: true
            }
        }
    }
</script>
<template>
    <div class="overlay">
        <div class="m-loader mr-4">
            <svg class="m-circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"/>
            </svg>
        </div>
        <h3 class="l-text">{{ text }}</h3>
    </div>
</template>

<script>
    export default {
        props: {
            text: {
                type: [String, Number],
                default: "Loading..."
            }
        }
    }
</script>
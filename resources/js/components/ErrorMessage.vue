<template>
    <div class="alert alert-danger success-msg bg-danger text-white" v-if="message">
        <i class="fa fa-check"></i>
        {{ message }}
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            let _this = this;
            this.$root.$on('show_error_message', (text) => { // here you need to use the arrow function
                _this.message = text;
                setTimeout(function () {
                    _this.message = "";
                }, 2000)
            })
        },
        data: function () {
            return {
                message: ""
            }
        },
        methods: {}
    }
</script>

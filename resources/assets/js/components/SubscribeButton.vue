<template>
    <button :class="classes" @click="subscribe">
        Subscribe
    </button>
</template>

<script>
    export default{
        props: ['isActive'],

        data() {
            return {
                active: this.isActive
            }
        },

        computed: {
            classes() {
                return ['uk-button uk-button-small', this.active ? 'uk-button-primary' : 'uk-button-default' ];
            }
        },

        methods: {
            subscribe() {
                axios[(this.active ? 'delete' : 'post')](location.pathname + '/subscribtions');

                this.active = ! this.active;
            }
        }

    };
</script>

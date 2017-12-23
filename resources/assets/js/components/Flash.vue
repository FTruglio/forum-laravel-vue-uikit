<template>
    <div class="alert-flash" uk-alert v-show="show" >
        <h3>Notice</h3>
        <p>{{body}}</p>
    </div>
</template>

<script>
export default {

    props: ['message'],

    data() {
        return {
            body: this.message,
            show: false
        }
    },
    created() {
        if (this.message) {
            this.flash(this.message);
        }
        // Listening to event emmited in bootstrap.js
        window.events.$on('flash', message => this.flash(message));
    },

    methods: {

        flash(message) {
            this.body = message;
            this.show = true;

            this.hide();
        },

        hide() {
            setTimeout(() => {
                this.show = false;
            }, 3000);
        }
    }
};
</script>

<style>
.alert-flash {
    position: fixed;
    right: 25px;
    bottom: 25px;
}
</style>

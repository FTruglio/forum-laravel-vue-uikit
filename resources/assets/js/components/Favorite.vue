<template>
    <div>
        <button :class="classes" @click="toggle">
            <span uk-icon="icon: heart"></span>
            <span v-text="favoritesCount"></span>
        </button>
    </div>

</template>

<script>
export default {
    props: [ 'reply' ],

    data () {
        return {
            favoritesCount: this.reply.favoritesCount,
            active: this.reply.isFavorited
        }
    },

    computed: {
        classes () {
            return [ 'uk-button uk-button-small uk-border-rounded', this.active ? 'uk-button-primary' : 'uk-button-default'];
        },

        endpoint() {
            return '/replies/' + this.reply.id + '/favorites';
        }
    },

    methods: {
        toggle() {
            this.active ? this.destroy() : this.create();
        },

        destroy() {
            axios.delete(this.endpoint);

            this.active = false;
            this.favoritesCount --;
        },

        create() {
         axios.post(this.endpoint);

         this.active = true;
         this.favoritesCount ++;
     }
 }

};
</script>

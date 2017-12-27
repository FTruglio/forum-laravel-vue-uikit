<template>
    <div :id="'reply-' + id" class="uk-card uk-card-default uk-margin-small-top">
        <div class="uk-card-header">
            <div class="uk-child-width-expand" uk-grid>
                <div>
                    <h5>
                        <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name">
                        </a> said <span v-text="ago"></span>
                    </h5>
                </div>
            </div>
            <div>
                <div class="uk-align-right" v-if="signedIn">
                    <favorite :reply="data"></favorite>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <div v-if="editing">
                <div class="uk-margin">
                    <textarea class="uk-textarea" v-model="body"></textarea>
                </div>
                <button class="uk-button uk-button-primary uk-border-rounded uk-button-small" @click="update"> Update</button>
                <button class="uk-button uk-button-default uk-border-rounded uk-button-small" @click="editing = false"> Cancel</button>
            </div>
            <div v-else v-text="body"></div>
        </div>
        <div class="uk-card-footer" v-if="canUpdate">
           <button class="uk-button uk-button-default uk-border-rounded uk-button-small" @click="editing = true"> Edit</button>
           <button class="uk-button uk-button-danger uk-border-rounded uk-button-small" @click="destroy">X Destroy</button>

       </div>
   </div>
</template>

<script>

import Favorite from './Favorite.vue';
import moment from 'moment';

export default {
    props: [
    'data'
    ],

    components: { Favorite },

    data() {
        return {
            editing: false,
            id: this.data.id,
            body: this.data.body
        }
    },

    computed: {

        ago() {
            return moment(this.data.created_at).fromNow() + '...';
        },

        signedIn() {
            return window.App.signedIn;
        },

        canUpdate() {
            // Using a mixin registered in the bootstrap.js use a more flexible authorize global.
            return this.authorize(user => this.data.user_id == user.id);
        }
    },

    methods: {
        update() {
            axios.patch('/replies/' + this.data.id, {
                body: this.body
            }).catch(error => {
                flash(error.response.data, 'danger');
            });

            this.editing = false;
            flash('Reply updated!', 'success');
        },

        destroy() {
            axios.delete('/replies/' + this.data.id);
            // The child component Reply.vue is emmiting an event that the item has been deleted. Now the parent component Replies.vue can listen for the event.
            this.$emit('deleted', this.data.id);

            // $(this.$el).fadeOut(300, () => {
            //     flash('Your reply has been deleted!');
            // });
        },
    }

};
</script>

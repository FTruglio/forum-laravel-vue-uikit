<template>
    <div :id="'reply-' + id" class="uk-card uk-margin-small-top uk-box-shadow-medium" :class="isBest? 'uk-card-primary' : 'uk-card-default'">
        <div class="uk-card-header">
            <div class="uk-child-width-expand" uk-grid>
                <div>
                    <h5>
                        <a :href="'/profiles/' + dataReply.owner.name" v-text="dataReply.owner.name">
                        </a> said <span v-text="ago"></span>
                    </h5>
                </div>
            </div>
            <div>
                <div class="uk-align-right" v-if="signedIn">
                    <favorite :reply="dataReply"></favorite>
                </div>
            </div>
        </div>
        <div class="uk-card-body">
            <div v-if="editing">
                <form @submit="update">
                    <div class="uk-margin">
                        <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
                    </div>
                    <button class="uk-button uk-button-primary uk-border-rounded uk-button-small"> Update</button>
                    <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" @click="editing = false"> Cancel</button>
                </form>
            </div>
            <div v-else v-html="body">
            </div>
        </div>
        <div class="uk-card-footer uk-child-width-expand" v-if="authorize('owns', dataReply) || authorize('owns', dataReply.thread)" uk-grid>
            <div v-if="authorize('owns', dataReply)">
             <button class="uk-button uk-button-default uk-border-rounded uk-button-small" @click="editing = true"> Edit</button>
             <button class="uk-button uk-button-danger uk-border-rounded uk-button-small" @click="destroy">X Destroy</button>
         </div>

         <div>
             <button v-if="authorize('owns', dataReply.thread)" class="uk-button uk-align-right uk-button-primary uk-border-rounded uk-button-small" v-show="! isBest" @click="markBest">Best Reply?</button>
         </div>

     </div>
 </div>
</template>

<script>

import Favorite from './Favorite.vue';
import moment from 'moment';

export default {
    props: [
    'dataReply'
    ],

    components: { Favorite },

    data() {
        return {
            editing: false,
            id: this.dataReply.id,
            body: this.dataReply.body,
            isBest: this.dataReply.isBest,
            completed: false
        }
    },

    computed: {
        ago() {
            return moment(this.dataReply.created_at).fromNow() + '...';
        },
    },

    created () {
        window.events.$on('best-reply-selected', id => {
            this.isBest = (id === this.id);
        })
    },

    methods: {
        update() {
            axios.patch('/replies/' + this.dataReply.id, {
                body: this.body
            }).catch(error => {
                flash(error.response.data, 'danger');
            });

            this.completed = true;

            this.editing = false;

            flash('Reply updated!', 'success');
        },

        destroy() {
            axios.delete('/replies/' + this.id);
            // The child component Reply.vue is emmiting an event that the item has been deleted. Now the parent component Replies.vue can listen for the event.
            this.$emit('deleted', this.id);

            // $(this.$el).fadeOut(300, () => {
            //     flash('Your reply has been deleted!');
            // });
        },

        markBest() {
            axios.post('/replies/' + this.id + '/best');

            flash('This is the best reply');

            window.events.$emit('best-reply-selected', this.id);
        }
    }

};
</script>

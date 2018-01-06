<template>
    <div>
        <div v-if="signedIn">
            <div class="uk-card uk-card-default uk-margin-small-top">
                <div class="uk-card-header">
                    <h4 class="uk-card-title">Contribute</h4>
                </div>
                <div class="uk-card-body">
                    <wysiwyg name="body" v-model="body" placeholder="Have something to say?" :shouldClear="completed"></wysiwyg>
                </div>
                <div class="uk-card-footer">
                    <button class="uk-button uk-button-primary uk-align-right" @click="addReply">Submit</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p class="uk-text-center">Please <a href="/login"> sign in </a> to participate in this discussion.</p>
        </div>
    </div>

</template>

<script>
import 'at.js';
import 'jquery.caret';

export default {
    data (){
        return {
            body: '',
            completed: false
        }
    },

    mounted() {
        $('#inputor').atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    $.getJSON("/api/users", {name: query}, function(usernames) {
                        callback(usernames)
                    });
                }
            }
        });
    },

    methods: {
        addReply() {
            axios.post(location.pathname + '/replies', { body: this.body})
            // response =>  response.data
            // short hand for ES2016 ({data}) => data
            .then(({data}) => {
                this.body = '';

                this.completed = true;

                flash('Your reply has been posted.', 'success');

                this.$emit('created', data);
            }).catch(error => {
                flash(error.response.data, 'danger');
            });
        }
    }
};
</script>

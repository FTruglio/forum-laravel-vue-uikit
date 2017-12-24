<template>

    <div>
        <div v-if="signedIn">
            <div class="uk-card uk-card-default uk-margin-small-top">
                <div class="uk-card-header">
                    <h4 class="uk-card-title">Contribute</h4>
                </div>
                <div class="uk-card-body">
                    <textarea
                    class="uk-textarea"
                    placeholder="Have something to say?"
                    rows="5"
                    v-model="body"></textarea>
                </div>
                <div class="uk-card-footer">
                    <button class="uk-button uk-button-primary uk-align-right" @click="addReply">Submit</button>
                </div>
            </div>
        </div>
        <div v-else>
            <p>Please <a href="/login"> sign in </a> to participate in this discussion.</p>
        </div>
    </div>

</template>

<script>
export default {

    props: ['endpoint'],

    data (){
        return {
            body: '',
        }
    },
    computed: {
        signedIn() {
            return window.App.signedIn;
        }
    },

    methods: {
        addReply() {
            axios.post(this.endpoint, { body: this.body})
            // response =>  response.data
            // short hand for ES2016 ({data}) => data
            .then(({data}) => {
                this.body = '';

                flash('Your reply has been posted.');

                this.$emit('created', data);
            });
        }
    }
};
</script>

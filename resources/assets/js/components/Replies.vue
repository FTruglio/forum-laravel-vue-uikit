<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)" :key="reply.id"></reply>
        </div>

        <paginator :dataSet="dataSet" @changed="fetchData"></paginator>

        <new-reply @created="add"></new-reply>
    </div>

</template>

<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
import collection from '../mixins/collection';

export default {
    props: ['data'],

    components: { Reply, NewReply },

    mixins: [ collection ],

    data() {
        return {
            dataSet: false,
            endpoint: location.pathname + '/replies'
        }
    },

    created() {
        this.fetchData();
    },

    methods: {

        fetchData(page) {
            axios.get(this.url(page)).then(this.refresh);
        },

        url(page) {
            if (! page) {
                let query = location.search.match(/page=(\d+)/);
                // if there is a query get the first item otherwise default to 1.
                page = query ? query[1] : 1;
            }

            return location.pathname + '/replies?page=' + page;
        },

        refresh({data}) {
            this.dataSet = data;
            this.items = data.data;

            //returns the user to the the top of the page after reoloading the data.
            window.scrollTo(0,0);
        },
    }
};
</script>

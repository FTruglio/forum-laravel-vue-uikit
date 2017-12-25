<template>
    <ul class="uk-pagination" v-if="shouldPaginate">
        <li v-show="prevUrl">
            <a href="#" rel="prev" @click.prevent="page--"><span class="uk-margin-small-right" uk-pagination-previous></span> Previous</a>
        </li>
        <li v-show="nextUrl" class="uk-margin-auto-left">
            <a href="#" rel="next" @click.prevent="page++">Next <span class="uk-margin-small-left" uk-pagination-next></span></a>
        </li>
    </ul>

</template>

<script>
export default {
    props: ['dataSet'],

    data() {
        return {
            page: 1,
            prevUrl: false,
            nextUrl: false
        }
    },

    watch: {
        dataSet() {
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
        },

        page() {
            // fire an event up the chain
            this.broadcast().updateUrl();
        }
    },

    computed: {
        shouldPaginate() {
            return !! this.prevUrl || !! this.nextUrl;
        }
    },

    methods: {
        broadcast() {
            // $emit returns the vm
            return this.$emit('changed', this.page);
        },

        updateUrl() {
            history.pushState(null, null, '?page=' + this.page);
        }
    }
};
</script>

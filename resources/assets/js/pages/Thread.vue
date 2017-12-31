<script>
import Replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    props: ['dataThread'],

    components: { Replies, SubscribeButton },

    data() {
        return {
            repliesCount: this.dataThread.replies_count,
            locked: this.dataThread.locked
        }
    },

    methods: {
        lock() {
            this.locked = true;

            axios.post('/locked-threads/' + this.dataThread.slug);
        }
    }
};
</script>

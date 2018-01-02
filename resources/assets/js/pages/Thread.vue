<script>
import Replies from '../components/Replies.vue';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    props: ['dataThread'],

    components: { Replies, SubscribeButton },

    data() {
        return {
            repliesCount: this.dataThread.replies_count,
            locked: this.dataThread.locked,
            editing: false,
            title: this.dataThread.title,
            body: this.dataThread.body,
            form: {
                title: this.dataThread.title,
                body: this.dataThread.body
            }
        }
    },

    methods: {
        toggleLock() {
            let uri = `/locked-threads/${this.dataThread.slug}`;

            axios[this.locked ? 'delete' : 'post'](uri);

            this.locked = ! this.locked;
        },

       update() {
            //axios
            // /threads/channel/thread-slug
            let uri = `/threads/${this.dataThread.channel.slug}/${this.dataThread.slug}`;

            axios.patch(uri, this.form).then( () => {
                this.editing = false;

                this.title = this.form.title;
                this.body = this.form.body;

                flash('Your thread has been updated');
            });
        },
        resetForm() {
         this.editing = false;

         this.form.title = this.dataThread.title;
         this.form.body = this.dataThread.body;
     }

 }
};
</script>

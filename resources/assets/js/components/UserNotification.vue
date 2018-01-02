<template>
    <div class="uk-offcanvas-content" v-if="notifications.length">

        <!-- The whole page content goes here -->
        <span uk-icon="icon: bell" type="button" uk-toggle="target: #offcanvas-usage"></span>

        <div id="offcanvas-usage" uk-offcanvas="flip: true">
            <div class="uk-offcanvas-bar" style="background-color: #fff; border-left: 1px solid #bdbdbd">

                <button class="uk-offcanvas-close" type="button" style="color: #bdbdbd" uk-close></button>

                <div v-for="notification in notifications">
                    <div class="uk-card uk-card-default uk-card-body uk-margin-small-top">
                        <a style="color: #4a4a4a"
                        :href="notification.data.link"
                        v-text="notification.data.message"
                        @click="markAsRead(notification)"
                        ></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            notifications: false,
        }
    },

    computed: {
        user () {
            return window.App.user;
        }
    },

    created() {
        if (this.user) {
            axios.get('/profiles/' + this.user.name + '/notifications')
            .then(({data}) => {this.notifications = data});
        }
    },

    methods: {
        markAsRead(notification) {
            axios.delete('/profiles/' + this.user.name + '/notifications/' + notification.id);
        }
    }
};
</script>

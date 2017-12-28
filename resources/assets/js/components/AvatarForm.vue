<template>
    <div class="uk-heading-divider">
        <div class="uk-child-width-1-3" uk-grid>
            <div>
                <img :src="avatar" :alt="user.name" style="width: 100px; height: auto; max-height: 200px;">
            </div>
            <div>
                <h1 class="uk-margin-medium-right" v-text="user.name"></h1>
            </div>
        </div>
        <form v-if="canUpdate" method="POST"  enctype="multipart/form-data">
            <image-upload name="avatar" @loaded="onLoad"></image-upload>
        </form>
    </div>
</template>

<script>
import ImageUpload from './ImageUpload';
export default {
    props: ['user'],

    components: { ImageUpload },

    data () {
        return {
            avatar: this.user.avatar_path,
        }
    },

    computed: {
        canUpdate() {
            return this.authorize(user => user.id === this.user.id)
        }
    },

    methods: {
        onLoad(avatar) {
            this.avatar = avatar.src;
                //Persist to the server
                this.persist(avatar.file);
            },

            persist(avatar) {
                let data = new FormData();

                data.append('avatar', avatar);

                axios.post('/api/users/' + this.user.name + '/avatar', data)
                .then( () => flash('Avatar updated'));
            }
        }
    };
    </script>

<template>
    <input type="file" accept="image/*" @change="onChange">
</template>

<script>
export default {

    methods: {
        onChange (e) {
            if (! e.target.files.length) {
                return;
            }
            // console.log(e.target.files[0]);
            let file = e.target.files[0];

            let reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = (e) => {
                    this.$emit('loaded', {
                        src: e.target.result,
                        file: file
                    });
                    // Note: arrow function used here, so that "this.file" refers to the file of Vue component
                    // Read image as base64 and set to imageData
                    // this.file = e.target.result;
                }
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(file);
            }
        }
    };
    </script>

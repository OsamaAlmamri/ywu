<template>
    <div id="my-strictly-unique-vue-upload-multiple-image"
         style="display: flex; justify-content: center;">
        <vue-upload-multiple-image
            @upload-success="uploadImageSuccess"
            @before-remove="beforeRemove"
            :data-images="images"
            idUpload="myIdUpload"
            editUpload="myIdEdit"
            :showPrimary="false"
            :showEdit="false"
            :maxImage="4"
            :dragText="$t('register.dragText')"
            :browseText="$t('register.browseText')"
            :primaryText="$t('register.primaryText')"
            :markIsPrimaryText="$t('register.markIsPrimaryText')"
            :popupText="$t('register.popupText')"
            :dropText="$t('register.dropText')"
        ></vue-upload-multiple-image>
    </div>
</template>

<script>
    import VueUploadMultipleImage from 'vue-upload-multiple-image'
    import axios from 'axios'

    export default {
        name: 'app',
        data() {
            return {
                images: [],
                uploaded_image: [],
            }
        },
        components: {
            VueUploadMultipleImage
        },
        methods: {
            uploadImageSuccess(formData, index, fileList) {
                console.log('data', formData, index, fileList)
                // Upload image api
                axios({url: '/api/upload_image', data: formData, method: 'POST'})
                    .then(resp => {
                        if (resp.data.status == false) {
                            toastStack('   خطاء ', resp.data.msg, 'error');
                            fileList.slice(index, 1)
                        } else {
                            fileList[index].name = resp.data.data;
                            fileList[index].name = resp.data.data;
                            console.log(resp.data);
                        }
                    })
                    .catch(err => {
                        fileList.slice(index, 1)
                        reject(err)
                    })
            },
            beforeRemove(index, done, fileList) {
                console.log('index', index, fileList)
                var r = confirm("remove image")
                if (r == true) {
                    done()
                } else {
                }
            },
            // editImage(formData, index, fileList) {
            //     console.log('edit data', formData, index, fileList)
            // }
        }
    }
</script>

<style>
    #my-strictly-unique-vue-upload-multiple-image {
        font-family: 'Avenir', Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        margin-top: 60px;
    }

    h1, h2 {
        font-weight: normal;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        display: inline-block;
        margin: 0 10px;
    }

    a {
        color: #42b983;
    }
</style>




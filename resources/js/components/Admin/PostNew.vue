<template>
    <div class="modal" v-show="value.modalOpen" style="display: flex">
        <div class="modal-dialog modal-dialog-centered" style="width: 500px">
            <div class="modal-content">
                <div class="modal-header" v-if="this.value.edit">Edit Post</div>
                <div class="modal-header" v-else>New Post</div>
                <div class="modal-body">
                    <form @submit.prevent="addPost" class="mb-3">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Title" v-model="value.title">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Author" v-model="value.author">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" placeholder="Body" v-model="value.body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark btn-block">Save</button>
                        <button type="button" class="btn btn-danger btn-block" @click="closeForm()">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'ModalForm',
        props: {
            value: {
                required: true
            },
            ObjPasspost : {}
        },
        data() {
            return {
                posts: [],
                post: {
                    _id: '',
                    author:'',
                    title: '',
                    body: '',
                    image: ''
                },
                post_id: '',
                edit: false,
                modalOpen: false
            }
        },
        methods: {
            addPost() {
                if(this.value.edit === false) {
                    //Add
                    fetch('api/post', {
                        method: 'post',
                        body: JSON.stringify(this.value),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.post.title = '';
                            this.post.body = '';
                            alert('Post Added');
                            this.$emit("input", !this.value.modalOpen);
                            window.location = ("/home");

                        })
                } else {
                    //Update
                    fetch('api/post', {
                        method: 'put',
                        body: JSON.stringify(this.value),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            this.post.title = '';
                            this.post.author = '';
                            this.post.body = '';
                            alert('Post Updated!');
                            this.$emit("input", !this.value.modalOpen);
                            window.location = ("/home");

                        })
                }
            },
            closeForm() {
                this.$emit("input", !this.value.modalOpen);
                window.location = ("/home");
            }
        }
    };


</script>
<style lang="css" scoped>
    .modal {
        background-color: rgba(0, 0, 0, 0.7);
    }
</style>

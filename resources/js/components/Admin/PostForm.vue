<template>
    <div>
        <nav aria-label="Page navigation example">
            <button class="btn btn-dark float-right" @click="openModal">New Post</button>
            <ModalForm v-model="ObjPasspost" ></ModalForm>
            <ul class="pagination ">
                <li v-bind:class="[{disabled: !pagination.prev_page_url }]" class="page-item shadow-lg">
                    <a class="page-link shadow-lg" href="#" tabindex="-1" aria-disabled="true" @click="fetchPosts(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page}} of {{ pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url }]" class="page-item">
                    <a class="page-link shadow-lg" href="#" @click="fetchPosts(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card-columns">
            <div class="card border shadow-lg p-3 mb-5 bg-white" style="width: 20rem;" v-for="post in posts" v-bind:key="post._id">
                <img :src="post.image" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ post.title}}</h5>
                    <p class="card-text">{{ post.body}}</p>
                    <button type="button" @click="editPost(post)" class="btn btn-dark">Edit</button>
                    <button type="button" @click="deletePost(post._id)" class="btn btn-dark">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import ModalForm from "./PostNew";
    export default {
        components: {
            ModalForm
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
                pagination: {},
                ObjPasspost: {
                    modalOpen: false,
                    _id: '',
                    author:'',
                    title: '',
                    body: '',
                    image: '',
                    edit: false
                }
            }
        },

        created() {
            this.fetchPosts();
        },

        methods: {
            fetchPosts(page_url) {
                let vm = this;
                page_url = page_url || 'api/posts'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.posts = res.data;
                        vm.makePaggination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePaggination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination =pagination;
            },
            deletePost(id){
                if (confirm('Would you like to delete this post?')){
                    fetch(`api/post/${id}`, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Post deleted !');
                            this.fetchPosts();
                        })
                        .catch(err => console.log(err));
                }
            },
            //Opens modal and gives post data for edit
            editPost(post) {
                this.ObjPasspost.modalOpen = true;
                this.ObjPasspost._id = post._id;
                this.ObjPasspost.post_id = post._id;
                this.ObjPasspost.title = post.title;
                this.ObjPasspost.author = post.author;
                this.ObjPasspost.body = post.body;
                this.ObjPasspost.edit = true;
            },
            //Opens modal for new post
            openModal() {
                this.ObjPasspost.modalOpen = true;
            }
        }
    };
</script>

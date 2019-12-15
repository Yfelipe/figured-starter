<template>
    <div>
        <nav aria-label="Page navigation">
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
                    <small class="text-muted">{{ post.author}}</small>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
                posts: [],
                post: {
                    _id: '',
                    title: '',
                    body: '',
                    image: ''
                },
                post_id: '',
                pagination: {},
                edit: false
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
            }
        }
    };
</script>

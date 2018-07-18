<template>
    <div>   
        <h2>Articles</h2>
        <form class="mb-3" @submit.prevent="addArticle">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Title" v-model="article.title">
                <br>
                <textarea class="form-control" name="body" id="body" cols="30" rows="3" placeholder="body" v-model="article.body"></textarea>
            </div>
            <input type="submit" value="Submit" class="btn btn-success">
        </form>
        <div class="card card-body mb-2" v-for="article in articles" v-bind:key = "article.id">
            <h3>{{article.title}}</h3>
            <p>{{article.body}}</p>
            <hr>
            <button class="btn btn-success mb-2" @click="editArticle(article)">Edit</button>
            <button class="btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page)">Next</a></li>
            </ul>
            </nav>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: [],
                article: {
                    id:'',
                    title:'',
                    body:''
                },
                article_id:'',
                pagination:{},
                edit:false
            }
        },

        created(){
            this.fetchArticles();
        },

        methods:{
            fetchArticles(page_url){
                let vm = this;
                page_url = page_url || 'api/articles';
                fetch(page_url)
                .then(response => response.json())
                .then(response =>{
                    this.articles = response.data;
                    vm.makePagination(response.meta, response.links);
                })
                .catch(err => console.log(err))
            },
            makePagination(meta, links){
                let pagination = {
                    current_page : meta.current_page,
                    last_page : meta.last_page,
                    next_page : links.next,
                    prev_page : links.prev
                };
                this.pagination = pagination;
            },
            deleteArticle(id){
                if(confirm('Are You Sure?')){
                    fetch('api/articles/'+ id,{
                        method:'delete'
                    })
                    .then(response => response.json())
                    .then(data =>{
                        alert('Article Removed');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
                }
            },
            addArticle(){
                if(this.edit === false){
                    //add
                    fetch('api/articles',{
                        method:'post',
                        body:JSON.stringify(this.article),
                        headers:{
                            'Content-Type':'application/json'
                        }
                    })
                    .then(response=>response.json())
                    .then(data =>{
                        this.article.title = '';
                        this.article.body = '';
                        alert('Article Created');
                        this.fetchArticles();
                    })
                    .catch(err=>console.log(err))
                }else{
                    //update
                    fetch('api/articles',{
                        method:'put',
                        body:JSON.stringify(this.article),
                        headers:{
                            'Content-Type':'application/json'
                        }
                    })
                    .then(response=>response.json())
                    .then(data =>{
                        this.article.title = '';
                        this.article.body = '';
                        alert('Article Edited');
                        this.fetchArticles();
                    })
                    .catch(err=>console.log(err))   
                }
            },
            editArticle(article){
                this.edit = true;
                this.article.id = article.id;
                this.article.article_id = article.id;
                this.article.title = article.title;
                this.article.body = article.body;
            }
        }
    }
</script>


<template>
    <div class="comments">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <span class="glyphicon glyphicon-comment"></span> Chat
                    </div>
                    <div class="panel-body">
                        <ul class="chat" id="chatWindow" style="height: 200px; overflow-y: scroll">
                            <li v-for="(comment, index) in comments" class="left clearfix" style="list-style: none" :key="index">
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong>
                                            {{ comment.user }}
                                        </strong>: {{ comment.comment}}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <form method="POST" v-on:submit.prevent="submit" :action="add_comment_url">
                        <div class="panel-footer">
                            <div class="input-group">
                                <input
                                    v-model="comment"
                                    name="comment"
                                    type="text"
                                    class="form-control input-sm"
                                    placeholder="Escribe tu mensaje..."
                                />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-warning btn-sm">Enviar</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Vue from 'vue';

export default {
    props: ['add_comment_url', 'get_comments_url', 'post_id'],
    methods: {
        submit(){
            Vue.http.post(this.add_comment_url, {'comment': this.comment}).then((response) => {
                this.comment = '';
            })
        }
    },
    data() {
        return {
            comments: [],
            comment: ''
        }
    },
    updated() {
        var el = document.getElementById('chatWindow');
        el.scrollTop = el.scrollHeight;
    },
    mounted() {
        Vue.http.get(this.get_comments_url).then((response) => {
            _.forEach(response.data, (comment) => {
                this.comments.push({
                    comment: comment.comment,
                    user: comment.user.name
                })
            })
        });

        window.Echo.private(`comments.${this.post_id}`)
            .listen('FireComment', (e) => {
                e.comment.user = e.user.name;
                this.comments.push({
                    comment: e.comment.comment,
                    user: e.user.name
                })
            })
    }
}
</script>

<template>
    <div class="comment-system">
        <h2>Comments for {{ feedbackName }}</h2>
        <div v-if="comments && comments.length > 0" class="comments-container">
            <div v-for="(comment, index) in comments" :key="index" class="comment">
                <div class="comment-header">
                    <span class="comment-user">{{ comment.user.name }}</span>
                    <span class="comment-date">{{ new Date(comment.created_at).toLocaleDateString() }}</span>
                </div>
                <p class="comment-content">{{ comment.comment }}</p>
            </div>
        </div>
        <div v-else class="no-comments">
            <p>No comments yet.</p>
        </div>
        <div class="comment-form">
            <form @submit.prevent="submitComment">
                <label for="content">Add Comment:</label>
                <textarea placeholder="mention @" v-model="newComment.content" @keyup="checkForMention"></textarea>
                <div v-if="showMentions" class="mentions-list">
                    <ul>
                        <li v-for="user in filteredUsers" :key="user.id" @click="addMention(user)">
                            {{ user.name }}
                        </li>
                    </ul>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "UserComments",
    data() {
        return {
            itemId: null,
            comments: [],
            newComment: {
                content: '',
                user: '',
                feedbackName: '',
            },
            users: [], // List of users to mention
            showMentions: false,
            mentionQuery: '',
        };
    },
    async created() {
        this.itemId = this.$route.params.itemId;
        this.newComment.itemId = this.itemId;
        this.feedbackName = this.$route.query.name;
        await this.fetchComments(); // Fetch comments on component creation
        await this.fetchUsers();
    },
    computed: {
        filteredUsers() {
            return this.users.filter(user => user.name.toLowerCase().includes(this.mentionQuery.toLowerCase()));
        },
    },
    methods: {
        async fetchComments() {
            try {
                const response = await axios.get(`/api/get-comments`, {
                    params: {
                        feedbackId: this.itemId
                    }
                });

                this.comments = response.data.comments;

            } catch (error) {
                console.error('Error fetching comments:', error);
            }
        },
        async submitComment() {
            try {
                const response = await axios.post(`/api/submit-comment/`, {
                    comment: this.newComment.content,
                    itemId: this.itemId
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${localStorage.getItem('userToken')}`
                    }
                });
                if (response.status === 200) {
                    this.newComment.content = ''; // Clear comment content after submission
                    this.newComment.user = '';
                    await this.fetchComments(); // Refresh comments list
                } else {
                    console.error('Failed to add comment:', response.statusText);
                }
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error('Error adding comment:', error);
                }
            }
        },
        async fetchUsers() {
            try {
                const response = await axios.get('/api/users-for-mention');
                this.users = response.data.users;
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        checkForMention(event) {
            const lastAtPos = this.newComment.content.lastIndexOf('@');
            if (lastAtPos > -1) {
                const currentPos = event.target.selectionStart;
                if (currentPos > lastAtPos) {
                    this.mentionQuery = this.newComment.content.substring(lastAtPos + 1, currentPos);
                    this.showMentions = true;
                }
            } else {
                this.showMentions = false;
            }
        },
        addMention(user) {
            const lastAtPos = this.newComment.content.lastIndexOf('@');
            this.newComment.content = this.newComment.content.substring(0, lastAtPos) + '@' + user.name + ' ';
            this.showMentions = false;
        },
    }
};
</script>
<style scoped>
.comment-system {
    max-width: 600px;
    margin: auto;
    padding: 1em;
    font-family: Arial, sans-serif;
}

.comments-container {
    margin-top: 1em;
    border-top: 1px solid #ccc;
}

.comment {
    padding: 1em;
    border-bottom: 1px solid #ccc;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    font-size: 0.9em;
    color: #555;
}

.comment-user {
    font-weight: bold;
}

.comment-date {
    color: #999;
}

.comment-content {
    margin-top: 0.5em;
    line-height: 1.4;
}

.no-comments {
    text-align: center;
    color: #999;
    margin-top: 2em;
}

.comment-form > form {
    margin-top: 2em;
}

.comment-form textarea {
    width: 100%;
    padding: 0.5em;
    margin-bottom: 1em;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.comment-form button {
    padding: 0.5em 1em;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.comment-form button:hover {
    background-color: #0056b3;
}

.mentions-list {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ddd;
    list-style-type: none;
    padding: 0;
    margin-top: 8px;
}
.mentions-list ul {
    padding-left: 0;
}
.mentions-list li {
    padding: 8px;
    cursor: pointer;
}
.mentions-list li:hover {
    background-color: #f0f0f0;
}
</style>

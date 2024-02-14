<template>
    <div class="feedback-list-container">
        <ul class="feedback-list">
            <li v-for="item in feedbackList.data" :key="item.id" class="feedback-item">
                <h3 class="feedback-title">{{ item.title }}</h3>
                <p class="feedback-description">{{ item.description }}</p>
                <p class="feedback-category">Category: {{ item.category.name }}</p>
                <p class="feedback-submitter">Submitted by: {{ item.user.name }}</p>
                <!-- Add Comment Button -->
                <button class="btn-add-comment" @click="addComment(item.id, item.category.name )">Add Comment</button>
            </li>
        </ul>
        <button class="btn-load-more" @click="fetchFeedback" v-if="feedbackList.next_page_url">Load More</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'FeedbackListComponent',
    data() {
        return {
            feedbackList: {},
        };
    },
    created() {
        this.fetchFeedback();
    },
    methods: {
        async fetchFeedback() {
            try {
                // Get userToken from local storage
                const userToken = localStorage.getItem('userToken');

                // Make sure userToken is available
                if (!userToken) {
                    console.error('User token not found in local storage');
                    return;
                }

                const response = await axios.get('/api/feedback', {
                    headers: {
                        Authorization: `Bearer ${userToken}`
                    }
                });
                this.feedbackList = response.data;
            } catch (error) {
                console.error('Error fetching feedback:', error);
            }
        },
        addComment(itemId, feedbackName) {
            this.$router.push({ path: `/user-comments/${itemId}`, query: { name: feedbackName } });
            console.log("Open comment modal for item:", itemId);
        },
    },
};
</script>
<style>
.feedback-list-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.feedback-list {
    list-style-type: none;
    padding: 0;
}

.feedback-item {
    background-color: #f9f9f9;
    border: 1px solid #e1e1e1;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 10px;
}

.feedback-title {
    color: #333;
    margin-bottom: 5px;
}

.feedback-description {
    color: #666;
    font-size: 14px;
}

.feedback-category, .feedback-submitter {
    font-size: 12px;
    color: #888;
    margin-bottom: 5px;
}

.btn-add-comment {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.btn-add-comment:hover {
    background-color: #0056b3;
}

.btn-load-more {
    background-color: #28a745;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    width: 100%;
    font-weight: bold;
}

.btn-load-more:hover {
    background-color: #218838;
}
</style>

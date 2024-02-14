<template>
    <div class="feedback-form-container">
        <h2>Submit Feedback</h2>
        <form @submit.prevent="submitFeedback">
            <!-- Title Field -->
            <div>
                <label for="title">Title:</label>
                <input type="text" id="title" v-model="feedback.title" required>
            </div>
            <!-- Description Field -->
            <div>
                <label for="description">Description:</label>
                <textarea id="description" v-model="feedback.description" required></textarea>
            </div>
            <!-- Category Field -->
            <div>
                <label for="category">Category:</label>
                <select id="category" v-model="feedback.category_id" required>
                    <option disabled value="">Please select one</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit">Submit</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "FeedbackFormComponent",
    data() {
        return {
            feedback: {
                title: '',
                description: '',
                category_id: ''
            },
            categories: [],
            errors: {}
        }
    },
    mounted() {
        this.fetchCategories();
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get('/api/feedback-categories');
                this.categories = response.data;
            } catch (error) {
                console.error('There was an error fetching the categories:', error);
            }
        },
        async submitFeedback() {
            try {
                await axios.post('/api/feedback', this.feedback);
                alert('Feedback submitted successfully!');
                this.$router.push('/feedback-list');
                // Reset form or redirect as needed
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                } else {
                    console.error('An error occurred:', error);
                }
            }
        }
    }
}
</script>

<style scoped>
.feedback-form-container {
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
}

.feedback-form-container h2 {
    text-align: center;
    margin-bottom: 1.5rem;
}

.feedback-form-container form {
    display: flex;
    flex-direction: column;
}

.feedback-form-container form > div {
    margin-bottom: 1rem;
}

.feedback-form-container label {
    display: block;
    margin-bottom: .5rem;
    font-weight: 600;
}

.feedback-form-container input[type="text"],
.feedback-form-container textarea,
.feedback-form-container select {
    width: 100%;
    padding: .8rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.feedback-form-container button {
    padding: .8rem 2rem;
    background-color: #0056b3;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    margin-top: 1rem;
}

.feedback-form-container button:hover {
    background-color: #003d82;
}

/* Responsive styles */
@media (max-width: 768px) {
    .feedback-form-container {
        padding: 1rem;
    }

    .feedback-form-container form > div {
        margin-bottom: 0.8rem;
    }

    .feedback-form-container button {
        padding: 0.8rem;
    }
}
</style>

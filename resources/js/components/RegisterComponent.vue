<template>
    <div class="register-container">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="user.email" required>
                <div v-if="errors.email" class="error">{{ errors.email[0] }}</div>
            </div>
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="user.name" required>
                <div v-if="errors.name" class="error">{{ errors.name[0] }}</div>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="user.password" required>
                <div v-if="errors.password" class="error">{{ errors.password[0] }}</div>
            </div>
            <div>
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" id="password_confirmation" v-model="user.password_confirmation" required>
                <div v-if="errors.password_confirmation" class="error">{{ errors.password_confirmation[0] }}</div>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "RegisterComponent",
    data() {
        return {
            user: {
                email: '',
                name: '',
                password: '',
                password_confirmation: ''
            },
            errors: {}
        }
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/register', this.user);
                localStorage.setItem('userToken', response.data.token);
                this.$router.push('/login'); // Redirect only after successful registration
            } catch (error) {
                if (error.response && error.response.status === 422) {
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
.register-container {
    max-width: 400px;
    margin: auto;
    padding: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="email"], input[type="text"], input[type="password"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 20px;
}

button {
    padding: 10px 20px;
    cursor: pointer;
}

.error {
    color: red;
    margin-top: 5px;
}
</style>

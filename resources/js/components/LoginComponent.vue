<template>
    <div class="login-container">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <!-- Email Field -->
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="credentials.email" required>
                <div v-if="errors.email" class="error">{{ errors.email[0] }}</div>
            </div>
            <!-- Password Field -->
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="credentials.password" required>
                <div v-if="errors.password" class="error">{{ errors.password[0] }}</div>
            </div>
            <!-- Submit Button -->
            <button type="submit">Login</button>
        </form>
    </div>
</template>
<!--<script>-->
<!--import axios from 'axios';-->

<!--export default {-->
<!--    name: "LoginComponent",-->
<!--    data() {-->
<!--        return {-->
<!--            credentials: {-->
<!--                email: '',-->
<!--                password: ''-->
<!--            },-->
<!--            errors: {}-->
<!--        }-->
<!--    },-->
<!--    methods: {-->
<!--        login() {-->
<!--            axios.get('/sanctum/csrf-cookie').then(() => {-->
<!--                axios.post('/api/login', this.credentials)-->
<!--                    .then(response => {-->
<!--                        // Handle success-->
<!--                        console.log('Login Successful:', response);-->
<!--                        this.$router.push('/dashboard'); // Redirect to the dashboard-->
<!--                    })-->
<!--                    .catch(error => {-->
<!--                        // Handle error-->
<!--                        if (error.response && error.response.data) {-->
<!--                            // Display errors from Laravel validation-->
<!--                            this.errors = error.response.data.errors || {};-->
<!--                            console.error('Login Error:', error.response.data.message);-->
<!--                        } else {-->
<!--                            // Handle other errors-->
<!--                            console.error('Login Error:', error);-->
<!--                        }-->
<!--                    });-->
<!--            });-->
<!--        }-->
<!--    }-->
<!--}-->
<!--</script>-->

<script>
import axios from 'axios';

export default {
    name: "LoginComponent",
    data() {
        return {
            credentials: {
                email: '',
                password: ''
            },
            errors: {}
        }
    },
    methods: {
        async login() {
            try {
                // Send the login request to the server
                const response = await axios.post('/api/login', this.credentials);
                localStorage.setItem('userToken', response.data.access_token);
                // Set the axios Authorization header globally with the received token
                axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.access_token}`;
                // Redirect to the dashboard
                this.$router.push('/provide-feedback');
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
.login-container {
    max-width: 400px;
    margin: 1rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.login-container h2 {
    text-align: center;
    margin-bottom: 1.5rem;
    color: #333;
}

.login-container form {
    display: flex;
    flex-direction: column;
}

.login-container label {
    margin-bottom: 0.5rem;
    color: #333;
}

.login-container input[type="email"],
.login-container input[type="password"] {
    padding: 0.8rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

.login-container .error {
    color: red;
    font-size: 0.8rem;
    margin-bottom: 0.5rem;
}

.login-container button {
    padding: 0.8rem;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 0.5rem;
}

.login-container button:hover {
    background-color: #0056b3;
}

/* Responsive styles */
@media (max-width: 600px) {
    .login-container {
        padding: 1rem;
        margin: 1rem;
    }

    .login-container input[type="email"],
    .login-container input[type="password"] {
        padding: 0.6rem;
    }

    .login-container button {
        padding: 0.6rem;
    }
}
</style>

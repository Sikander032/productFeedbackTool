<template>
    <div class="dashboard-container">
        <div class="auth-button">
            <router-link v-if="!isLoggedIn" to="/login" class="button">Login</router-link>
            <button v-else @click="logout" class="button">Logout</button>
        </div>
        <div class="button-group">
            <router-link to="/register" class="button">Register</router-link>
            <router-link to="/login" class="button">Login</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "DashboardComponent",
    computed: {
        isLoggedIn() {
            // Check if userToken exists in localStorage
            return localStorage.getItem('userToken') !== null;
        }
    },
    methods: {
        logout() {
            // Remove the token and refresh the page or redirect the user to the home page
            localStorage.removeItem('userToken');
            this.$router.push('/');
            // You might also want to clear the authentication header or make a logout API call
        }
    }
}
</script>

<style scoped>
.dashboard-container {
    position: relative;
    height: 100vh;
}

.auth-button {
    position: absolute;
    top: 0;
    right: 0;
    margin: 10px;
}

.button {
    padding: 10px 20px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #0056b3;
}
</style>

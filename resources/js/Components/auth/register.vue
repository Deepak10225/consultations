<template>
  <div class="auth-container">
    <h2>Register</h2>
    <form @submit.prevent="register">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="name" type="text" id="name" placeholder="Enter your name" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="email" type="email" id="email" placeholder="Enter your email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input v-model="password" type="password" id="password" placeholder="Enter your password" required />
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input v-model="password_confirmation" type="password" id="password_confirmation" placeholder="Confirm your password" required />
      </div>
      <button type="submit" :disabled="loading">Register</button>
      <p v-if="error" class="error">{{ error }}</p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      password_confirmation: '',
      loading: false,
      error: null
    };
  },
  methods: {
    async register() {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.post('http://your-laravel-api/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation
        });

        this.$router.push('/login'); // Redirect to login
      } catch (err) {
        this.error = 'Registration failed. Please try again.';
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: auto;
}
.error {
  color: red;
  font-size: 14px;
}
</style>

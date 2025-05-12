<template>
  <div>
    <h1>Your Profile</h1>
    <form @submit.prevent="updateProfile">
      <div class="form-group">
        <label for="name">Name</label>
        <input v-model="user.name" type="text" id="name" />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input v-model="user.email" type="email" id="email" />
      </div>
      <button type="submit">Save Changes</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: {}
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    async fetchUser() {
      const response = await axios.get('http://your-laravel-api/api/user', {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      });
      this.user = response.data;
    },
    async updateProfile() {
      await axios.put('http://your-laravel-api/api/user', this.user, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      });
      alert('Profile updated!');
    }
  }
};
</script>

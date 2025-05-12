<template>
  <div>
    <h2>Create Consultation</h2>
    <form @submit.prevent="submitForm">
      <input v-model="title" placeholder="Title" required />
      <textarea v-model="description" placeholder="Description" required></textarea>
      <input v-model="scheduled_at" type="datetime-local" required />
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      title: '',
      description: '',
      scheduled_at: '',
    };
  },
  methods: {
    async submitForm() {
      const token = localStorage.getItem('token');
      await axios.post(
        'http://127.0.0.1:8000/api/consultations',
        {
          title: this.title,
          description: this.description,
          scheduled_at: this.scheduled_at,
        },
        { headers: { Authorization: `Bearer ${token}` } }
      );
      this.$router.push('/consultations');
    },
  },
};
</script>

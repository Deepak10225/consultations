<template>
  <div>
    <h1>{{ consultation.title }}</h1>
    <p>{{ consultation.description }}</p>
    <p>Scheduled at: {{ consultation.scheduled_at }}</p>
    <button @click="editConsultation">Edit</button>
    <button @click="cancelConsultation">Cancel</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      consultation: {}
    };
  },
  created() {
    this.fetchConsultation();
  },
  methods: {
    async fetchConsultation() {
      const response = await axios.get(`http://your-laravel-api/api/consultations/${this.$route.params.id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      });
      this.consultation = response.data;
    },
    editConsultation() {
      this.$router.push(`/consultations/edit/${this.$route.params.id}`);
    },
    async cancelConsultation() {
      await axios.delete(`http://your-laravel-api/api/consultations/${this.$route.params.id}`, {
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`
        }
      });
      this.$router.push('/dashboard'); // Redirect to dashboard
    }
  }
};
</script>

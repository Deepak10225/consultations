<template>
  <div>
    <h2>My Consultations</h2>

    <input v-model="search" @input="fetchConsultations" placeholder="Search by title, description or date" />

    <router-link to="/consultations/new">Create New</router-link>

    <ul>
      <li v-for="consultation in consultations" :key="consultation.id">
        <h3>{{ consultation.title }}</h3>
        <p>{{ consultation.description }}</p>
        <p><strong>Scheduled:</strong> {{ consultation.scheduled_at }}</p>
        <router-link :to="`/consultations/${consultation.id}/edit`">Edit</router-link>
        <button @click="deleteConsultation(consultation.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      consultations: [],
      search: '',
    };
  },
  mounted() {
    this.fetchConsultations();
  },
  methods: {
    async fetchConsultations() {
      const token = localStorage.getItem('token');
      const res = await axios.get('http://127.0.0.1:8000/api/consultations', {
        headers: { Authorization: `Bearer ${token}` },
        params: { search: this.search },
      });
      this.consultations = res.data;
    },
    async deleteConsultation(id) {
      if (confirm('Are you sure you want to delete?')) {
        const token = localStorage.getItem('token');
        await axios.delete(`http://127.0.0.1:8000/api/consultations/${id}`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        this.fetchConsultations();
      }
    },
  },
};
</script>

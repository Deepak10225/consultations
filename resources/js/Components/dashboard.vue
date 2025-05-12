<template>
  <div>
    <h1>Welcome to your Dashboard</h1>
    <button @click="scheduleConsultation">Schedule New Consultation</button>

    <h3>Upcoming Consultations</h3>
    <ul>
      <li v-for="consultation in consultations" :key="consultation.id">
        <span>{{ consultation.title }}</span> - <span>{{ consultation.scheduled_at }}</span>
        <button @click="viewConsultation(consultation.id)">View</button>
        <button @click="cancelConsultation(consultation.id)">Cancel</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      consultations: []
    };
  },
  created() {
    this.fetchConsultations();
  },
  methods: {
    async fetchConsultations() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/consultations', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        this.consultations = response.data;
      } catch (error) {
        console.error('Error fetching consultations', error);
      }
    },
    scheduleConsultation() {
      this.$router.push('/consultations');
    },
    async viewConsultation(id) {
      this.$router.push(`/consultations/${id}`);
    },
    async cancelConsultation(id) {
      try {
        await axios.delete(`http://127.0.0.1:8000i/api/consultations/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        });
        this.fetchConsultations(); 
      } catch (error) {
        console.error('Error cancelling consultation', error);
      }
    }
  }
};
</script>

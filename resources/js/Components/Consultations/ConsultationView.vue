<template>
  <div class="consultation-view" v-if="consultation">
    <h2 class="text-2xl font-semibold mb-4">{{ consultation.title }}</h2>
    <p class="text-gray-500 mb-2">ID: {{ consultation.id }}</p>
    <p class="mb-4">{{ consultation.description }}</p>
    
    <!-- Additional Consultation Details -->
    <div class="details">
      <p><strong>Status:</strong> {{ consultation.status }}</p> 
      <p><strong>Created At:</strong> {{ consultation.created_at }}</p>
      <p><strong>Updated At:</strong> {{ consultation.updated_at }}</p>
    </div>
  </div>
  <div v-else class="text-gray-500">Loading consultation...</div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

export default {
  name: 'ConsultationView',
  props: {
    id: {
      type: Number,
      required: true
    }
  },
  setup(props) {
    const consultation = ref(null);

    onMounted(() => {
      const token = localStorage.getItem('token');
      
      if (token) {
        axios.get(`/api/consultations/${props.id}`, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        })
        .then(response => {
          consultation.value = response.data;
        })
        .catch(error => {
          console.error('Error fetching consultation:', error);
        });
      } else {
        console.error('Token is missing or invalid');
      }
    });

    return {
      consultation
    };
  }
};
</script>

<style scoped>
</style>

<template>
  <div>
    <h2>Edit Consultation</h2>
    <form @submit.prevent="updateForm">
      <input v-model="title" placeholder="Title" required />
      <textarea v-model="description" placeholder="Description" required></textarea>
      <input v-model="scheduled_at" type="datetime-local" required />
      <button type="submit">Update</button>
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
  async created() {
    const id = this.$route.params.id;
    const token = localStorage.getItem('token');
    const res = await axios.get(`http://127.0.0.1:8000/api/consultations/${id}`, {
      headers: { Authorization: `Bearer ${token}` },
    });

    this.title = res.data.title;
    this.description = res.data.description;
    this.scheduled_at = res.data.scheduled_at;
  },
  methods: {
    async updateForm() {
      const id = this.$route.params.id;
      const token = localStorage.getItem('token');
      await axios.put(
        `http://127.0.0.1:8000/api/consultations/${id}`,
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

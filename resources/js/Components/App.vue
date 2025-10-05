<template>
  <div>
    <!-- Auth Pages (no layout) -->
    <div v-if="isAuthPage">
      <router-view></router-view>
    </div>
    
    <!-- Main App (with layout) -->
    <app-layout v-else :user="user">
      <router-view></router-view>
    </app-layout>
  </div>
</template>

<script>
import AppLayout from './Layout/AppLayout.vue'

export default {
  name: 'App',
  components: {
    AppLayout
  },
  data() {
    return {
      user: {
        name: '',
        email: '',
        created_at: ''
      }
    }
  },
  computed: {
    isAuthPage() {
      return this.$route.name === 'login' || this.$route.name === 'register';
    }
  },
  async mounted() {
    if (!this.isAuthPage) {
      await this.loadUserData();
    }
  },
  watch: {
    '$route.name': {
      async handler(newRouteName) {
        if (!this.isAuthPage) {
          await this.loadUserData();
        }
      }
    }
  },
  methods: {
    async loadUserData() {
      try {
        const response = await axios.get('/user');
        if (response.data.success) {
          this.user = response.data.data;
        }
      } catch (error) {
        console.error('Error loading user data:', error);
        if (error.response?.status === 401) {
          this.$router.push('/login');
        }
      }
    }
  }
}
</script>
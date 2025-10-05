<template>
  <app-layout :user="user">
    <div class="max-w-4xl mx-auto">
      <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-gray-900">Share Your Smoke Break</h1>
          <p class="mt-2 text-gray-600">Document your thoughts, feelings, and ideas during this moment</p>
        </div>

        <!-- Create post form -->
        <form @submit.prevent="submitPost" class="space-y-6">
          <!-- Title -->
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
            <input
              v-model="form.title"
              type="text"
              id="title"
              required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
              placeholder="What's on your mind during this smoke break?"
              maxlength="255"
            >
            <p class="mt-1 text-sm text-gray-500">{{ form.title.length }}/255 characters</p>
          </div>

          <!-- Cigarette Selection -->
          <div>
            <label for="cigarette" class="block text-sm font-medium text-gray-700 mb-2">Which cigarette are you smoking?</label>
            <select
              v-model="form.cigarette_id"
              id="cigarette"
              required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
            >
              <option value="">Select a cigarette</option>
              <option v-for="cigarette in cigarettes" :key="cigarette.id" :value="cigarette.id">
                {{ cigarette.brand.name }} - {{ cigarette.name }} ({{ cigarette.strength }})
              </option>
            </select>
          </div>

          <!-- Rating & Count -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Rating -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-2">How was it?</label>
              <div class="flex space-x-1 mb-2">
                <button
                  v-for="star in 5"
                  :key="star"
                  type="button"
                  @click="form.rating = star"
                  class="text-3xl focus:outline-none transition duration-200 transform hover:scale-110"
                  :class="star <= form.rating ? 'text-yellow-500' : 'text-gray-300'"
                >
                  ★
                </button>
              </div>
              <p class="text-sm text-gray-600">{{ form.rating }}/5 stars</p>
            </div>

            <!-- Cigarettes Count -->
            <div>
              <label for="cigarettes_count" class="block text-sm font-medium text-gray-700 mb-2">How many did you smoke?</label>
              <div class="relative">
                <input
                  v-model="form.cigarettes_count"
                  type="number"
                  id="cigarettes_count"
                  min="1"
                  max="10"
                  class="block w-32 px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
                >
              </div>
            </div>
          </div>

          <!-- Content -->
          <div>
            <label for="body" class="block text-sm font-medium text-gray-700 mb-2">Your thoughts, feelings, or ideas...</label>
            <textarea
              v-model="form.body"
              id="body"
              rows="8"
              required
              class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
              placeholder="Share what you're thinking about, how you're feeling, any ideas that came to mind during your smoke break..."
              maxlength="1000"
            ></textarea>
            <p class="mt-1 text-sm text-gray-500">{{ form.body.length }}/1000 characters</p>
          </div>

          <!-- Buttons -->
          <div class="flex justify-end space-x-3 pt-6 border-t">
            <router-link
              to="/dashboard"
              class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 font-medium"
            >
              Cancel
            </router-link>
            <button
              type="submit"
              :disabled="loading || form.body.length < 10"
              class="px-6 py-3 bg-indigo-600 border border-transparent rounded-lg text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 font-medium disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <span v-if="loading">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sharing...
              </span>
              <span v-else>Share Experience</span>
            </button>
          </div>

          <!-- Error Message -->
          <div v-if="error" class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ error }}
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>

export default {
  name: 'CreatePost',
  data() {
    return {
      loading: false,
      error: '',
      cigarettes: [],
      user: {
        name: '',
        email: ''
      },
      form: {
        title: '',
        cigarette_id: '',
        rating: 3,
        cigarettes_count: 1,
        body: ''
      }
    }
  },
  async mounted() {
    await this.loadUserData();
    await this.loadCigarettes();
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
        this.$router.push('/login');
      }
    },
    async loadCigarettes() {
      try {
        const response = await axios.get('/cigarettes');
        if (response.data.success) {
          this.cigarettes = response.data.data;
        }
      } catch (error) {
        console.error('Failed to load cigarettes:', error);
        this.error = 'Failed to load cigarettes. Please try again.';
      }
    },
    async submitPost() {
      this.loading = true;
      this.error = '';

      try {
        const response = await axios.post('/posts', this.form);
        
        if (response.data.success) {
          this.$router.push('/dashboard');
        }
      } catch (error) {
        if (error.response?.data?.errors) {
          this.error = Object.values(error.response.data.errors).flat().join(' ');
        } else {
          this.error = error.response?.data?.message || 'Failed to create post. Please try again.';
        }
      } finally {
        this.loading = false;
      }
    }
  }
}
</script>
<template>
  <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center p-4">
    <div class="max-w-md w-full space-y-8 bg-white rounded-2xl shadow-xl p-8">
      <!-- Logo Section -->
      <div class="flex justify-center">
        <div class="flex flex-col items-center space-y-3">
          <div class="h-16 w-16 rounded-2xl flex items-center justify-center shadow-lg">
            <img 
              src="/images/smokebreakidea.png" 
              alt="SmokeBreakIdea" 
              class="h-10 w-10 filter"
              onerror="this.style.display='none'"
            >
          </div>
          <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-900">SmokeBreakIdea</h1>
          </div>
        </div>
      </div>

      <!-- Login Form -->
      <div class="text-center">
        <p class="mt-2 text-gray-600">Sign in to your account</p>
      </div>
      
      <form @submit.prevent="login" class="space-y-6">
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input 
            v-model="form.email" 
            type="email" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
            placeholder="Enter your email"
          >
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input 
            v-model="form.password" 
            type="password" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200"
            placeholder="Enter your password"
          >
        </div>
        
        <button 
          type="submit" 
          :disabled="loading"
          class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition duration-200 font-medium shadow-sm"
        >
          <span v-if="loading">
            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Signing In...
          </span>
          <span v-else>Sign In</span>
        </button>
      </form>
      
      <div class="text-center">
        <p class="text-gray-600">
          Don't have an account? 
          <router-link to="/register" class="text-indigo-600 hover:text-indigo-500 font-medium transition duration-200">
            Sign up
          </router-link>
        </p>
      </div>
    </div>

    <!-- Error Modal -->
    <error-modal 
      :show="showErrorModal" 
      :message="errorMessage"
      @close="showErrorModal = false"
    />
  </div>
</template>

<script>
import ErrorModal from '../Shared/ErrorModal.vue'

export default {
  name: 'Login',
  components: {
    ErrorModal
  },
  data() {
    return {
      loading: false,
      showErrorModal: false,
      errorMessage: '',
      form: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    async login() {
      this.loading = true
      this.showErrorModal = false

      try {
        const response = await axios.post('/login', this.form)
        
        if (response.data.success) {
          this.$router.push('/dashboard')
        }
      } catch (error) {
        this.errorMessage = error.response?.data?.message || 
                           error.response?.data?.error || 
                           'Login failed. Please check your credentials and try again.'
        this.showErrorModal = true
      } finally {
        this.loading = false
      }
    }
  }
}
</script>
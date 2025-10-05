<template>
  <div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-100 flex items-center justify-center p-4">
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
        </div>
      </div>

      <div class="text-center">
        <h2 class="text-3xl font-bold text-gray-900">Join SmokeBreakIdea</h2>
        <p class="mt-2 text-gray-600">Create your account</p>
      </div>
      
      <form @submit.prevent="register" class="space-y-6">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
          <input 
            v-model="form.name" 
            type="text" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="Enter your full name"
          >
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
          <input 
            v-model="form.email" 
            type="email" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="Enter your email"
          >
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input 
            v-model="form.password" 
            type="password" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="Create a password"
          >
        </div>
        
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input 
            v-model="form.password_confirmation" 
            type="password" 
            required 
            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
            placeholder="Confirm your password"
          >
        </div>
        
        <button 
          type="submit" 
          class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition duration-200"
        >
          Create Account
        </button>
      </form>
      
      <div class="text-center">
        <p class="text-gray-600">
          Already have an account? 
          <router-link to="/login" class="text-green-600 hover:text-green-500 font-medium">
            Sign in
          </router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Register',
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    }
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('/register', this.form);
        
        if (response.data.success) {
          this.$router.push('/dashboard');
        }
      } catch (error) {
        console.error('Registration failed:', error);
        alert('Registration failed. Please try again.');
      }
    }
  }
}
</script>
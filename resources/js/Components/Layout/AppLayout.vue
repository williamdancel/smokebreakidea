<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm border-b">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex items-center">
            <router-link to="/dashboard" class="flex-shrink-0 flex items-center">
              <div class="h-8 w-8 rounded-lg flex items-center justify-center">
                <img src="/images/smokebreakidea.png" alt="Idea" class="h-8 w-8">
              </div>
              <span class="ml-2 text-xl font-bold text-gray-900">SmokeBreakIdea</span>
            </router-link>
            <div class="hidden md:ml-6 md:flex md:space-x-8">
              <router-link 
                to="/dashboard" 
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-200"
                :class="{
                  'border-indigo-500 text-gray-900': $route.name === 'dashboard',
                  'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': $route.name !== 'dashboard'
                }"
              >
                Dashboard
              </router-link>
              <router-link 
                to="/posts" 
                class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition duration-200"
                :class="{
                  'border-indigo-500 text-gray-900': $route.name === 'posts' || $route.name === 'post',
                  'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700': $route.name !== 'posts' && $route.name !== 'post'
                }"
              >
                All Posts
              </router-link>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <div class="text-right">
              <p class="text-sm font-medium text-gray-900">{{ user.name }}</p>
              <p class="text-xs text-gray-500">{{ user.email }}</p>
            </div>
            <button @click="logout" class="text-gray-500 hover:text-gray-700 transition duration-200 cursor-pointer">
              Logout
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <slot></slot>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'AppLayout',
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  methods: {
    async logout() {
      try {
        const response = await axios.post('/logout');
        
        if (response.data.success) {
          this.$router.push('/login');
        }
      } catch (error) {
        console.error('Logout failed:', error);
        window.location.href = '/login';
      }
    }
  }
}
</script>
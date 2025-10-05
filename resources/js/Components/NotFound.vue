<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center">
    <div class="text-center">
      <h1 class="text-4xl font-bold text-gray-900 mb-4">404</h1>
      <p class="text-xl text-gray-600 mb-8">Page not found</p>
      <router-link 
        to="/dashboard" 
        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition duration-200"
      >
        Go to Dashboard
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>
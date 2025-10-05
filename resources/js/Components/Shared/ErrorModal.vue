<template>
  <transition name="modal">
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4">
      <!-- Modal with strong shadow instead of background -->
      <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all border border-gray-100">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-red-200 bg-red-50 rounded-t-2xl">
          <div class="flex items-center space-x-3">
            <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
              </svg>
            </div>
            <h3 class="text-lg font-semibold text-red-800">Login Failed</h3>
          </div>
          <button @click="close" class="text-red-400 hover:text-red-600 transition duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <!-- Body -->
        <div class="p-6">
          <p class="text-gray-700">{{ message }}</p>
        </div>
        
        <!-- Footer -->
        <div class="flex justify-end p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
          <button 
            @click="close" 
            class="px-6 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200"
          >
            Try Again
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'ErrorModal',
  props: {
    show: {
      type: Boolean,
      default: false
    },
    message: {
      type: String,
      default: 'An error occurred.'
    }
  },
  methods: {
    close() {
      this.$emit('close');
    }
  }
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.modal-enter-from {
  opacity: 0;
  transform: scale(0.95) translateY(-10px);
}

.modal-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(-10px);
}
</style>
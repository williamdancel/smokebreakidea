<template>
  <app-layout :user="user">
    <!-- Welcome section -->
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ user.name }}! 👋</h1>
          <p class="mt-2 text-gray-600">Ready to share your next smoke break experience?</p>
        </div>
        <router-link 
          to="/posts/create" 
          class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 font-semibold shadow-lg"
        >
          ✍️ Share Experience
        </router-link>
      </div>
    </div>

    <!-- My Posts Section -->
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-900">My Posts</h2>
        <div class="text-sm text-gray-500">
          {{ posts.length }} {{ posts.length === 1 ? 'post' : 'posts' }}
        </div>
      </div>

      <!-- Loading State -->
      <div v-if="loading" class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
      </div>

      <!-- Empty State -->
      <div v-else-if="posts.length === 0" class="text-center py-8">
        <div class="text-gray-400 text-6xl mb-4">📝</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">No posts yet</h3>
        <p class="text-gray-500 mb-4">Share your first smoke break experience to get started!</p>
        <router-link 
          to="/posts/create" 
          class="inline-flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-200"
        >
          <span class="mr-2">✍️</span>
          Create First Post
        </router-link>
      </div>

      <!-- Posts Grid -->
      <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div 
          v-for="post in posts" 
          :key="post.id" 
          class="border border-gray-200 rounded-lg hover:shadow-md transition duration-200"
        >
          <!-- Post Image -->
          <div class="h-48 bg-gray-200 rounded-t-lg overflow-hidden">
            <img 
              v-if="post.image" 
              :src="post.image" 
              :alt="post.title"
              class="w-full h-full object-cover"
            >
            <div v-else class="w-full h-full flex items-center justify-center bg-gray-100">
              <span class="text-4xl text-gray-400">🚬</span>
            </div>
          </div>
          
          <!-- Post Content -->
          <div class="p-4">
            <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">
              {{ post.title }}
            </h3>
            <p class="text-gray-600 text-sm mb-3">
              {{ post.body }}
            </p>
            
            <!-- Actions -->
            <div class="flex space-x-2 mt-4">
              <!-- <router-link 
                :to="`/posts/${post.id}/edit`"
                class="flex-1 bg-gray-100 text-gray-700 text-center py-2 rounded hover:bg-gray-200 transition duration-200 text-sm"
              >
                Edit
              </router-link> -->
              <button 
                @click="deletePost(post.id)"
                class="flex-1 bg-red-50 text-red-600 text-center py-2 rounded hover:bg-red-100 transition duration-200 text-sm"
              >
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Load More Button -->
      <div v-if="hasMorePosts && !loading" class="flex justify-center mt-6">
        <button 
          @click="loadMorePosts"
          class="bg-white border border-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-50 transition duration-200"
        >
          Load More Posts
        </button>
      </div>
    </div>
  </app-layout>
</template>

<script>

export default {
  name: 'Dashboard',

  data() {
    return {
      user: {
        name: '',
        email: '',
        created_at: ''
      },
      posts: [],
      loading: false,
      currentPage: 1,
      hasMorePosts: false
    }
  },
  async mounted() {
    await this.loadUserData();
    await this.loadMyPosts();
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
      }
    },

    async loadMyPosts() {
      this.loading = true;
      try {
        const response = await axios.get('my-posts', {
          params: {
            page: this.currentPage
          }
        });
        
        if (response.data.success) {
          if (this.currentPage === 1) {
            this.posts = response.data.data;
          } else {
            this.posts = [...this.posts, ...response.data.data];
          }
          
          this.hasMorePosts = response.data.meta ? 
            response.data.meta.current_page < response.data.meta.last_page : 
            false;
        }
      } catch (error) {
        console.error('Error loading posts:', error);
        this.$toast.error('Failed to load your posts');
      } finally {
        this.loading = false;
      }
    },

    async loadMorePosts() {
      this.currentPage++;
      await this.loadMyPosts();
    },

    async deletePost(postId) {
      if (!confirm('Are you sure you want to delete this post?')) {
        return;
      }

      try {
        const response = await axios.delete(`/posts/${postId}`);
        
        if (response.data.success) {
          this.posts = this.posts.filter(post => post.id !== postId);
          this.$toast.success('Post deleted successfully');
        }
      } catch (error) {
        console.error('Error deleting post:', error);
        this.$toast.error('Failed to delete post');
      }
    },

    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    }
  }
}
</script>

<style scoped>
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.line-clamp-3 {
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style>
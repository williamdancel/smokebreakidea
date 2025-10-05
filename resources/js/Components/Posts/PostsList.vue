<template>
  <app-layout :user="user">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
      <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
        <div class="mb-4 lg:mb-0">
          <h1 class="text-3xl font-bold text-gray-900">Smoke Break Experiences 💨</h1>
          <p class="mt-2 text-gray-600">Discover smoking experiences shared by our community</p>
        </div>
        
        <!-- Filters and Search -->
        <div class="flex flex-col sm:flex-row gap-4">
          <!-- Search -->
          <div class="relative">
            <input
              v-model="searchQuery"
              type="text"
              placeholder="Search experiences..."
              class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full sm:w-64"
              @input="handleSearch"
            >
            <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
              </svg>
            </div>
          </div>

          <!-- Sort Dropdown -->
          <select
            v-model="sortBy"
            @change="loadPosts"
            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
          >
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="rating">Highest Rating</option>
            <option value="cigarettes">Most Cigarettes</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Posts Grid -->
      <div class="lg:col-span-3">
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-12">
          <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
        </div>

        <!-- Empty State -->
        <div v-else-if="!posts || posts.length === 0" class="text-center py-12 bg-white rounded-2xl shadow-sm border">
          <div class="text-gray-400 text-6xl mb-4">💨</div>
          <h3 class="text-xl font-semibold text-gray-600 mb-2">No experiences found</h3>
          <p class="text-gray-500 mb-6">
            {{ searchQuery ? 'No experiences match your search criteria.' : 'Be the first to share a smoke break experience!' }}
          </p>
          <router-link 
            to="/posts/create" 
            class="inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition duration-200 font-semibold"
          >
            <span class="mr-2">✍️</span>
            Share Your Experience
          </router-link>
        </div>

        <!-- Posts Grid -->
        <div v-else class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          <div 
            v-for="post in posts" 
            :key="post?.id || `post-${index}`" 
            class="bg-white rounded-2xl shadow-sm border hover:shadow-md transition duration-200 overflow-hidden"
          >
            <!-- Post Header with Author Info -->
            <div class="p-4 border-b">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <div class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-semibold">
                    {{ getAuthorInitial(post) }}
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ getAuthorName(post) }}</p>
                    <p class="text-xs text-gray-500">{{ formatDate(post.created_at) }}</p>
                  </div>
                </div>
                
              </div>
            </div>

            <!-- Post Content -->
            <div class="p-5">
              <!-- Title -->
              <h3 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 hover:text-indigo-600 cursor-pointer"
                  @click="viewPost(post)">
                {{ post.title || 'Untitled Experience' }}
              </h3>

              <!-- Body/Description -->
              <p class="text-gray-600 text-sm mb-4">
                {{ post.body || 'No description available.' }}
              </p>

              <!-- Cigarette Information -->
              <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-lg">
                <div class="flex items-center space-x-4">
                  <div class="flex items-center text-sm text-gray-600">
                    <span class="mr-1 text-lg">🚬</span>
                    <span>{{ post.cigarettes_count || 1 }} cig{{ post.cigarettes_count !== 1 ? 's' : '' }}</span>
                  </div>
                  
                  <!-- Rating -->
                  <div v-if="post.rating" class="flex items-center text-sm text-gray-600">
                    <span class="mr-1 text-yellow-500">⭐</span>
                    <span>{{ post.rating }}/5</span>
                  </div>

                  <!-- Cigarette Brand -->
                  <div v-if="post.cigarette" class="flex items-center text-sm text-gray-600">
                    <span class="mr-1">📛</span>
                    <span>{{ post.cigarette.brand_name }}</span>
                  </div>
                </div>
              </div>

             
            </div>
          </div>
        </div>

        <!-- Load More -->
        <div v-if="hasMorePosts && !loading" class="flex justify-center mt-8">
          <button 
            @click="loadMorePosts"
            :disabled="loadingMore"
            class="bg-white border border-gray-300 text-gray-700 px-8 py-3 rounded-lg hover:bg-gray-50 transition duration-200 font-medium disabled:opacity-50"
          >
            <span v-if="loadingMore" class="flex items-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Loading...
            </span>
            <span v-else>Load More Experiences</span>
          </button>
        </div>
      </div>

    </div>
  </app-layout>
</template>

<script>
export default {
  name: 'AllPosts',

  data() {
    return {
      user: {
        name: '',
        email: '',
        created_at: ''
      },
      posts: [],
      loading: false,
      loadingMore: false,
      currentPage: 1,
      hasMorePosts: false,
      searchQuery: '',
      sortBy: 'newest',
      searchTimeout: null
    }
  },

  async mounted() {
    await this.loadUserData();
    await this.loadPosts();
  },

  methods: {
    async loadUserData() {
      try {
        const response = await axios.get('/user');
        if (response.data && response.data.success) {
          this.user = response.data.data || {};
        }
      } catch (error) {
        console.error('Error loading user data:', error);
      }
    },

    async loadPosts(reset = true) {
      if (reset) {
        this.loading = true;
        this.currentPage = 1;
      } else {
        this.loadingMore = true;
      }

      try {
        const response = await axios.get('/posts', {
          params: {
            page: this.currentPage,
            search: this.searchQuery,
            sort: this.sortBy,
            per_page: 9
          }
        });
        if (response.data && response.data.success) {
          const newPosts = response.data.data.data || [];
          
          if (reset) {
            this.posts = newPosts;
          } else {
            this.posts = [...this.posts, ...newPosts];
          }
          
          if (response.data.meta) {
            this.hasMorePosts = response.data.meta.current_page < response.data.meta.last_page;
          } else {
            this.hasMorePosts = false;
          }
        } else {
          this.posts = [];
          this.hasMorePosts = false;
        }
      } catch (error) {
        console.error('Error loading posts:', error);
        this.$toast.error('Failed to load experiences');
        this.posts = [];
        this.hasMorePosts = false;
      } finally {
        this.loading = false;
        this.loadingMore = false;
      }
    },

    async loadMorePosts() {
      this.currentPage++;
      await this.loadPosts(false);
    },

    handleSearch() {
      clearTimeout(this.searchTimeout);
      this.searchTimeout = setTimeout(() => {
        this.loadPosts();
      }, 500);
    },

    viewPost(post) {
      if (!post || !post.id) {
        console.error('Cannot view post: post or post.id is null');
        return;
      }
      this.$router.push(`/posts/${post.id}`);
    },

   getAuthorName(post) {
    // Safe check for post and user data
    if (post && post.user) {
        return post.user.name || 'Unknown User';
    }
    
    // For posts from non-registered users
    if (post && post.author_name) {
        return post.author_name;
    }
    
    // For posts with user_id but no user data loaded
    if (post && post.user_id) {
        return 'User #' + post.user_id;
    }
    
    return 'Anonymous User';
    },

    getAuthorInitial(post) {
    const name = this.getAuthorName(post);
    return name ? name.charAt(0).toUpperCase() : 'U';
    },

    getStatusBadgeClass(status) {
      const statusClasses = {
        published: 'bg-green-100 text-green-800',
        draft: 'bg-yellow-100 text-yellow-800',
        archived: 'bg-gray-100 text-gray-800'
      };
      return statusClasses[status] || 'bg-gray-100 text-gray-800';
    },

    formatDate(dateString) {
      if (!dateString) return 'Unknown date';
      
      try {
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return 'Invalid date';
        
        return date.toLocaleDateString('en-US', {
          year: 'numeric',
          month: 'short',
          day: 'numeric'
        });
      } catch (error) {
        console.error('Error formatting date:', error);
        return 'Unknown date';
      }
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
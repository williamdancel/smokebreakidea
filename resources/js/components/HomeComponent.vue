<template>
    <div class="container">
        <p>{{ message }}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: 'Welcome to SmokeBreakIdea!',
            count: 0
        }
    },
    methods: {
        
    }
}
</script>

<style scoped>
.container {
    text-align: center;
    padding: 2rem;
}
</style>
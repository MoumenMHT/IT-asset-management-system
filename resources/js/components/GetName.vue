<!-- resources/js/components/RegisterForm.vue -->
<template>
        <span class="d-none d-md-block dropdown-toggle ps-2">{{name}}</span>
     
</template>

<script>
export default {
    data() {
        return {
            name: '',
        };
    },
    mounted() {
        // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
    },
    
}
    
</script>

<template>
    <div>
        <DashboardHome />
        <button @click ="logout">Logout</button>
    </div>  
</template>

<script>
import DashboardHome from '@/components/DashboardHome.vue';
export default {
    components: {
        DashboardHome,
    },
    methods: {
        logout() {
            localStorage.setItem('isAuthenticated', 'false');
            this.$router.push({ name: 'Auth' });
        }
    }
}
</script>
<template>
    <div class="dashboard">
        <DashboardHome />
        <button @click ="logout" class="btn">Logout</button>
    </div>  
</template>

<script setup>
import DashboardHome from '@/components/DashboardHome.vue';
import { useRouter } from 'vue-router';
import { onMounted } from 'vue';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const router = useRouter();
const logout = () => {
    localStorage.setItem('isAuthenticated', 'false');
    router.push({ name: 'Auth' });
};

onMounted(() => {
    toast.success('Connexion réussie')
})
// export default {
//     setup() {
//         toast.success('Connexion réussie');
//     },
//     components: {
//         DashboardHome,
//     },
//     methods: {
//         logout() {
//             localStorage.setItem('isAuthenticated', 'false');
//             this.$router.push({ name: 'Auth' });
//         }
//     }
// }
</script>
<style>
@import '../assets/form.css';
</style>
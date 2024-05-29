<template>
    <div class="container">
        <div class="forms-container">
            <div class="login-register">
                <form class="login-form" @submit.prevent="verifyToken">
                    <h2 class="title" v-if="qrCodeUrl">Authentification</h2>
                    <p>Scanner ce QR Code avec Google Authenticator ou Authy</p>
                    <img :src="qrCodeUrl" alt="QR Code" style="height: 300px;width: 300px;">
                    <label>Saisir le code:</label>
                    <div class="input-field">
                        <i class="fa-solid fa-user"></i>
                        <input v-model="token" type="text" required>
                    </div>
                    <button class="btn solid" type="submit">Verifier</button>
                </form>
            </div>
        </div>

        <div>
            <span></span>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { getQRCodeApi, verifyTokenApi } from '@/services/apiService';
import { useRouter } from 'vue-router';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const props = defineProps(['tempToken']);
const token = ref('');
const qrCodeUrl = ref('');
const router = useRouter();

onMounted(async () => {
        qrCodeUrl.value = await getQRCodeApi(props.tempToken);
});

const verifyToken = async () => {
    try {
        const success = await verifyTokenApi({ token: token.value, temp_token: props.tempToken });
        if (success){
            localStorage.setItem('isAuthenticated', 'true');
            router.push({ name: 'Dashboard'});
            toast.success('Code de vérification valide')
        } else {
            toast.error('Code de vérification invalide')
            resetCodeField();
        }
    } catch (error) {
        resetCodeField();
    }
};

const resetCodeField = () =>{
    token.value = "";
};
</script>

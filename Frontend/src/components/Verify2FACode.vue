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

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    props: ['tempToken'],
    data() {
        return {
            token: '',
            qrCodeUrl: '',
            router: useRouter(),
        };
    },
    async mounted() {
        try {
            const response = await axios.get(`http://127.0.0.1:8000/api/qrcode?temp_token=${this.tempToken}`);
            this.qrCodeUrl = response.data.qr_code_url;
        } catch (error) {
            console.error(error);
        }
    },
    methods: {
        async verifyToken() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/verify', {
                    token: this.token,
                    temp_token: this.tempToken,
                });
                if (response.data.success) {
                    localStorage.setItem('isAuthenticated', 'true')
                    this.router.push({ name: 'Dashboard'});
                }else {
                    alert('Invalid 2FA code AAA');
                    this.resetCodeField();
                }
            } catch (error) {
                console.error(error);
            }
        },
        resetCodeField(){
            this.token = "";
        },
    },
};
</script>

<template>
<div>
    <h2>Authentification</h2>
    <div v-if="qrCodeUrl">
        <p>Scanner ce QR Code avec Google Authenticator ou Authy</p>
        <img :src="qrCodeUrl" alt="QR Code">
    </div>
    <form @submit.prevent="verifyToken">
        <div>
            <label>Authentication Code:</label>
            <input v-model="token" type="text" required>
        </div>
        <button type="submit">Verifier</button>
    </form>
</div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['tempToken'],
    data() {
        return {
            token: '',
            qrCodeUrl: '',
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
                    alert('2FA successful');
                } else {
                    alert('Invalid 2FA code AAA');
                }
            } catch (error) {
                console.error(error);
            }
        },
    },
};
</script>

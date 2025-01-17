import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

// Function to register a new user
export const registerUserApi = async (user) => {
    try {
        await axios.post('http://127.0.0.1:8000/api/register', user);
        toast.success('Inscription avec succès. Connectez vous svp');
    }
    catch (error) {
        toast.error('Echec lors Inscription. Veuillez Reessayer SVP !', { autoClose: 2000 });
        throw error;
    }
};

// Function to log in a user
export const loginUserApi = async (credentials) => {
    try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', credentials);
        return response.data;
    }
    catch (error) {
        toast.error('Identifiant ou mot de passe invalide. Veuillez Reessayer SVP!', { autoClose: 2000 });
        throw error;
    }
};

// Function to get a QRCode url for 2FA 
export const getQRCodeApi = async (tempToken) => {
    const response = await axios.get(`http://127.0.0.1:8000/api/qrcode?temp_token=${tempToken}`);
    return response.data.qr_code_url;
};

// Function to verify 2FA token
export const verifyTokenApi = async (tokenData) => {
    const response = await axios.post('http://127.0.0.1:8000/api/verify', tokenData);
    return response.data.success;
};
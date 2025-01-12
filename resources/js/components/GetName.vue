<!-- resources/js/components/RegisterForm.vue -->
<template>
        <span class="d-none d-md-block dropdown-toggle ps-2">{{name}}</span>
     
</template>

<script>

import CryptoJS from 'crypto-js';

export default {
    data() {
        return {
            name: '',
        };
    },
    mounted() {
          // Get the encrypted query parameter
          const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        let encryptedData = urlParams.get('data');
        

        if (encryptedData) {
            try {
                // Decrypt the data
                const secretKey = "abdou";
                const bytes = CryptoJS.AES.decrypt(encryptedData, secretKey);
                const decryptedData = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));

                // Access the decrypted values
                console.log('Decrypted User Data:', decryptedData);
                const {  username } = decryptedData;
                

                this.name = username;


               


            } catch (error) {
                console.error('Failed to decrypt data:', error);
            }
        }
    },
    
}
    
</script>

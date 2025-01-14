<!-- resources/js/components/RegisterForm.vue -->
<template>
         <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> 
                <span class="d-none d-md-block dropdown-toggle ps-2">{{name}}</span>
            </a>
     
          
          <!-- End Profile Iamge Icon -->
    
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
    
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#"  @click="logout()">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>
    
          </ul><!-- End Profile Dropdown Items -->
        </li>
     
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
    methods:{
        logout() {
                  const token = localStorage.getItem('auth_token'); // Retrieve the token
                  if (!token) {
                      console.warn("No token found, user might already be logged out.");
                      return;
                  }

                  axios
                      .post('/api/logout', {}, {
                          headers: {
                              'Authorization': `Bearer ${token}`
                          },
                          withCredentials: true
                      })
                      .then((response) => {
                          console.log(response.data.message); // Logged out successfully
                          // Clear the token from localStorage
                          localStorage.removeItem('auth_token');

                          // Optionally redirect to the login page
                          window.location.href = '/'; // Adjust the path as needed
                      })
                      .catch((error) => {
                          console.error("Error during logout:", error);
                      });
              }
      } 
    
}
    
</script>

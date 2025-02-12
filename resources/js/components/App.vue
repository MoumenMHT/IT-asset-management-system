<!-- resources/js/components/App.vue -->
<template>
 
<div class="noreson">


  <!-- ======= Sidebar ======= -->
  
  <aside id="sidebar" class="sidebar">

    <ul v-if="this.type === 'admin'" class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/dashboard?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Dashoard</span>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/structure?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Structure</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/app?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>contract</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/fournisseur?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Fournisseur </span>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/magazin?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Magasin</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/affectation?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Affectation</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/employer?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>Employer</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/user?data=' + encodeURIComponent(encryptedData)">
          <i class="bi bi-grid"></i>
          <span>User</span>
        </router-link>
      </li>
      
      

    </ul>
    <ul v-else-if="this.type === 'worker'" class="sidebar-nav" id="sidebar-nav">

<li class="nav-item">
  <router-link class="nav-link collapsed" :to="'/dashboard?' ">
    <i class="bi bi-grid"></i>
    <span>Dashoard</span>
  </router-link>
</li>


<li class="nav-item">
  <router-link class="nav-link collapsed" :to="'/app?data=' + encodeURIComponent(encryptedData)">
    <i class="bi bi-grid"></i>
    <span>contract</span>
  </router-link>
</li>
<li class="nav-item">
  <router-link class="nav-link collapsed" :to="'/fournisseur?data=' + encodeURIComponent(encryptedData)">
    <i class="bi bi-grid"></i>
    <span>Fournisseur </span>
  </router-link>
</li>

<li class="nav-item">
  <router-link class="nav-link collapsed " :to="'/magazin?data=' + encodeURIComponent(encryptedData)">
    <i class="bi bi-grid"></i>
    <span>Magasin</span>
  </router-link>
</li>
<li class="nav-item">
  <router-link class="nav-link collapsed " :to="'/affectation?data=' + encodeURIComponent(encryptedData)">
    <i class="bi bi-grid"></i>
    <span>Affectation</span>
  </router-link>
</li>





</ul>
<ul v-else class="sidebar-nav" id="sidebar-nav">

<li class="nav-item">
  <router-link class="nav-link collapsed" :to="'/dashboard?data=' + encodeURIComponent(encryptedData)">
    <i class="bi bi-grid"></i>
    <span>Dashoard</span>
  </router-link>
</li>



</ul>

  </aside>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <!-- End Page Title -->

    <section class="section dashboard">
      
        <router-view></router-view>
          
      
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->

    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

</div>
</template>

<script>
import CryptoJS from 'crypto-js';
import axios from "axios";




export default {

  
    name: 'App',
    data() {
        return {
          username: '',
          type: '',
          encryptedData:'',
          notifications: [],

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
                const {  username, Type } = decryptedData;
                

                this.username = username;
                this.type = Type;


                const userData = JSON.stringify(decryptedData);
                encryptedData = CryptoJS.AES.encrypt(userData, secretKey).toString();
                this.encryptedData = encryptedData;


            } catch (error) {
                console.error('Failed to decrypt data:', error);
            }

            axios.get('/api/notifications')
            .then(response => {
                this.notifications = response.data;
                console.log('here', response);
            
            })
            .catch((error) => {
            console.log(error);
        });
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

        
};
</script>

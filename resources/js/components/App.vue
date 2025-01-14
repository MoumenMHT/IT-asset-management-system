<!-- resources/js/components/App.vue -->
<template>
  <header id="header" class="header fixed-top d-flex align-items-center">

<div class="d-flex align-items-center justify-content-between">
  <a href="/" class="logo d-flex align-items-center">
    <img src="{{asset('assets/img/logo.png')}}" alt="">
    <span class="d-none d-lg-block">GPI</span>
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div><!-- End Logo -->

<div class="search-bar">
  <form class="search-form d-flex align-items-center" method="POST" action="#">
    <input type="text" name="query" placeholder="Search" title="Enter search keyword">
    <button type="submit" title="Search"><i class="bi bi-search"></i></button>
  </form>
</div><!-- End Search Bar -->

<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="#">
        <i class="bi bi-search"></i>
      </a>
    </li><!-- End Search Icon-->

    <li class="nav-item dropdown">

      <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        <span class="badge bg-primary badge-number">4</span>
      </a><!-- End Notification Icon -->

      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
          You have 4 new notifications
          <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
        </li>
        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-exclamation-circle text-warning"></i>
          <div>
            <h4>Lorem Ipsum</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>30 min. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-x-circle text-danger"></i>
          <div>
            <h4>Atque rerum nesciunt</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>1 hr. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-check-circle text-success"></i>
          <div>
            <h4>Sit rerum fuga</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>2 hrs. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>

        <li class="notification-item">
          <i class="bi bi-info-circle text-primary"></i>
          <div>
            <h4>Dicta reprehenderit</h4>
            <p>Quae dolorem earum veritatis oditseno</p>
            <p>4 hrs. ago</p>
          </div>
        </li>

        <li>
          <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
          <a href="#">Show all notifications</a>
        </li>

      </ul><!-- End Notification Dropdown Items -->

    </li><!-- End Notification Nav -->

    <!-- End Messages Nav -->

    <li class="nav-item dropdown pe-3">
        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown"> 
          <div id="UserName">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{username}}</span>
          </div>
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
    </li><!-- End Profile Nav -->

  </ul>
</nav><!-- End Icons Navigation -->

</header>
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

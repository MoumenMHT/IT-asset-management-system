<!-- resources/js/components/App.vue -->
<template><div class="noreson">


  <!-- ======= Sidebar ======= -->
  
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/dashboard?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Dashoard</span>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/structur?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Structure</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/app?name=' + name">
          <i class="bi bi-grid"></i>
          <span>contract</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed" :to="'/fournisseur?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Fournisseur </span>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/magazin?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Magasin</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/affectation?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Affectation</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/employer?name=' + name">
          <i class="bi bi-grid"></i>
          <span>Employer</span>
        </router-link>
      </li>
      <li class="nav-item">
        <router-link class="nav-link collapsed " :to="'/user?name=' + name">
          <i class="bi bi-grid"></i>
          <span>User</span>
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
export default {

  
    name: 'App',
    data() {
        return {
            name: '',
        };
    },
    mounted() {
        // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
    },

        
};
</script>

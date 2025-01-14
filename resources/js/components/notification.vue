<!-- resources/js/components/RegisterForm.vue -->
<template>
<li class="nav-item dropdown">
  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
    <i class="bi bi-bell"></i>
    <span class="badge bg-primary badge-number">{{ notifications.length }}</span>
  </a><!-- End Notification Icon -->

  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
    <li class="dropdown-header">
      You have {{ notifications.length }} notifications
    </li>
    <li>
      <hr class="dropdown-divider">
    </li>

    <!-- Add a Bootstrap scrollable div -->
    <div class="overflow-auto" style="max-height: 300px;">
      <li v-for="(notification, index) in notifications" :key="index" class="notification-item">
        <i class="bi bi-exclamation-circle text-warning"></i>
        <div>
          <h4>{{ notification.data.message }}</h4>
          <p>{{ notification.data.date_amortissement }}</p>
        </div>
      </li>
    </div>
  </ul><!-- End Notification Dropdown Items -->
</li>

</template>

<script>


export default {
data() {
   return {
    notifications: [],
};
},
mounted() {
    axios.get('/api/notifications')
            .then(response => {
                this.notifications = response.data;
                console.log('here', response);
            
            })
            .catch((error) => {
            console.log(error);
        });
},


}

</script>

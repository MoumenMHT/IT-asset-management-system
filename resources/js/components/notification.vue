<template>
  <li class="nav-item dropdown">
    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
      <i class="bi bi-bell"></i>
      <span class="badge bg-primary badge-number">{{ notifications.length }}</span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
      <li class="dropdown-header">
        You have {{ notifications.length }} notifications
      </li>
      <li>
        <hr class="dropdown-divider" />
      </li>

      <ul class="overflow-auto" style="max-height: 300px;">
        <li
          v-for="(notification, index) in notifications"
          :key="index"
          class="notification-item"
          @click="openDialog(notification)"
        >
          <i class="bi bi-exclamation-circle text-warning"></i>
          <div>
            <h4>{{ notification.data?.message || 'No message available' }}</h4>
            <p>{{ notification.created_at || 'No date available' }}</p>
          </div>
        </li>
      </ul>
    </ul>

    <div
      class="modal fade"
      id="notificationDialog"
      tabindex="-1"
      aria-labelledby="notificationDialogLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-4">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fw-bold" id="notificationDialogLabel">
              Notification Details
            </h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body bg-light">
            <div v-if="selectedNotification?.data?.type === 'equipment'">
              <h3>Equipment Details</h3>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Serial Number</th>
                    <th>Brand</th>
                    <th>Condition</th>
                    <th>Status</th>
                    <th>amortization date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>

                    <td>{{ selectedNotification.data.array.num_serie }}</td>
                    <td>{{ selectedNotification.data.array.marque }}</td>
                    <td>{{ selectedNotification.data.array.etat }}</td>
                    <td>{{ selectedNotification.data.array.status }}</td>
                    <td>{{ selectedNotification.data.array.date_amortissement }}</td>

                  </tr>
                  <!-- Add more rows for other equipment details as needed -->
                </tbody>
              </table>
            </div>
            <div v-else-if="selectedNotification?.data?.type === 'contract'">
              <h3>Contract Details</h3>
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    
                    <th>Contract reffrence </th>
                    <th>Acquisition Date</th>
                    <th>Guarantee</th>
                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ selectedNotification.data.array.ref }}</td>
                    <td>{{ selectedNotification.data.array.date_acquisition }}</td>
                    <td>{{ selectedNotification.data.array.garantie }}</td>
                    

                  </tr>
                  <!-- Add more rows for other equipment details as needed -->
                </tbody>
              </table>            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button
              type="button"
              class="btn btn-success"
              data-bs-dismiss="modal"
              @click="notificationDone(selectedNotification)"
            >
              Done
            </button>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </li>
</template>

<script>
export default {
  data() {
    return {
      notifications: [], // List of notifications
      selectedNotification: { data: { type: '' } }, // Default notification
      contract: [],
      columns: [
        { label: 'Num', field: 'id' },
        { label: 'Contract Reference', field: 'ref' },
        { label: 'Fournisseur', field: 'fournisseur' },
        { label: 'Str Contract', field: 'structure' },
        { label: 'Garantie', field: 'garantie' },
        { label: 'Type Contract', field: 'Type_contract' },
        { label: 'Date Acquisition', field: 'date_acquisition' },
      ],
    };
  },
  mounted() {
    axios
      .get("/api/notifications")
      .then((response) => {
        this.notifications = response.data;
      })
      .catch((error) => {
        console.error("Error fetching notifications:", error);
      });
  },
  methods: {
    openDialog(notification) {
      this.selectedNotification = notification;
      console.log('hereeee', this.selectedNotification.data.type);
      

      // Initialize and show the modal without manually removing backdrops
      const modalElement = document.getElementById("notificationDialog");
      const modal = new bootstrap.Modal(modalElement, {
        backdrop: false, // Keep backdrop enabled
      });
      modal.show();
    },
    notificationDone(notification) {
      if (!notification || !notification.id) {
        console.error("Notification ID is required for deletion.");
        return;
      }

      axios
        .delete(`/api/notifications/${notification.id}`)
        .then(() => {
          // Remove the notification from the list
          this.notifications = this.notifications.filter(
            (n) => n.id !== notification.id
          );

          // Optionally, reset selectedNotification
          this.selectedNotification = { data: { type: '' } };

          console.log("Notification deleted successfully.");
        })
        .catch((error) => {
          console.error("Error deleting notification:", error);
        });
    },
  },
};
</script>

<style>
/* Prevent body from scrolling */
body.modal-open {
  overflow: hidden !important;
}

/* Notification item hover effect */
.notification-item {
  cursor: pointer;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}
.notification-item:hover {
  background-color: #f8f9fa;
}
</style>

<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">User Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            
            
            <div class="col-12">
                  <label class="form-label">Select employee</label>                 
                    <select class="form-select" aria-label="Default select example" v-model="form.employer" >
                      <option value="" disabled>Select a employes</option>
                      <option v-for="employe in employes" :key="employe.id" :value="employe.nom">
                       {{employe.prenom}}  {{ employe.nom }} 
                      </option>
                    </select>  
            </div>

            <div class="col-12">
              <label for="inputNanme4" class="form-label">Username</label>
              <input type="text" v-model="form.username" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Password</label>
              <input type="text" v-model="form.password" class="form-control" />
            </div>
            <div class="col-12">
                  <label class="form-label">Select User Type</label>                 
                    <select class="form-select" aria-label="Default select example" v-model="form.type" >
                      <option value="" disabled>Select a User Type</option>
                      <option  >admin</option>
                      <option  >worker</option>
                      <option  >viewer</option>
                    </select>  
            </div>
            
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
              &nbsp;
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <!-- Table Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">All users</h5>
          <div id="Table">
           <table class="table datatable" ref="datatable">
            <thead>
              <tr>
                <th>Num</th>
                <th>Employer Code</th>
                <th>Username</th>
                <th>Password</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display message when no users are available -->
              <tr v-if="users.length === 0">
                <td colspan="7" class="text-center">No users available.</td>
              </tr>

              <!-- Loop through users -->
              <tr v-for="(user, index) in users" :key="user.id">
                <!-- Editable Row -->
                <template v-if="editRow === user.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    {{ user.code }}
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="editableuser.username"
                      class="form-control"
                      placeholder="user Reference"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="editableuser.password"
                      class="form-control"
                      placeholder="user Reference"
                    />
                  </td>
                
                  
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="form.type" >
                      <option value="" disabled>{{user.type}}</option>
                      <option  >jfkjoih</option>
                      <option  >kkkk</option>
                    </select>
                  </td>
                  

                  <td>
                    <button
                      @click="confirmEdit(user.id, index)"
                      class="btn btn-success btn-sm"
                    >
                      Confirm
                    </button>
                    &nbsp;
                    <button
                      @click="cancelEdit()"
                      class="btn btn-secondary btn-sm"
                    >
                      Cancel
                    </button>
                  </td>
                </template>

                <!-- Normal Row -->
                <template v-else>
                  <td>{{ index +1 }}</td>
                  <td>{{ user.code }}</td>
                  <td>{{ user.username }}</td>
                  <td>{{ user.password }}</td>
                  <td>{{ user.type }}</td>

                  <td>
                    <button
                      @click="enableEdit(user)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deleteuser(user.id, index)"
                      class="btn btn-danger btn-sm"
                    >
                      Delete
                    </button>
                  </td>
                </template>
              </tr>
            </tbody>
          </table>


          </div>
        </div>
      </div>
    </div>
  
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      form: {
            username: '',
            password: '',
            type: '',
            employer: '',
        },
      users: [],
      employes: [],
      name: '',
      editRow: null, // To track the row being edited
      editableuser: {
            username: '',
            password: '',
            type: '',
            employer: '',
      }, // To temporarily store the editable user data
    };
  },
  mounted() {
    this.fetchUsers();
    this.getEmployer();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  methods: {

    

    
    fetchUsers() {
      axios
        .get("/api/user/getUser")
        .then((response) => {
          this.users = response.data;
          
          console.log(response.data);
          if(this.users){
            this.$nextTick(() => {
              
              this.initializeDataTable();
            });
          }
          
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error);
        });
    },
    initializeDataTable() {
      
      const tableRef = $(this.$refs.datatable);
      if ($.fn.DataTable.isDataTable(this.$refs.datatable)) {
        
        tableRef.DataTable().clear().destroy();
      }
      tableRef.DataTable({
        paging: true,
        searching: true,
        responsive: true,
      });
    },
      submitForm() {
            
            axios.post('/api/userCrud', this.form)
                .then(response => {
                    // Handle successful registration
                    alert(response.data.message);
                    console.log(response.data.debug);
                    
                })
                .catch(error => {
                    console.log(error);
                    
                });
},
    enableEdit(user) {
      if (user && user.id) {
      this.editRow = user.id;

      this.editableuser = { ...user }; // Store a copy of the user data
  } else {
    console.log('No valid user data found!');
  }
    },
    confirmEdit(id, index) {
        let updateduser = this.editableuser;
       
        console.log('Updated user Before Sending:', updateduser);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/userCrud/${id}`, updateduser)
            .then((response) => {
              
            alert(response.data.message);
            console.log(response.data.user);
            
            
            this.users[index] = { ...updateduser }; // Update user in the users array
            this.users[index].password = response.data.user;
            
            
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating user");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editableuser = {}; // Clear the temporary storage
    },
    deleteuser(id, index) {
      if (confirm("Are you sure you want to delete this user?")) {
        axios
          .delete(`/api/userCrud/${id}`)
          .then((response) => {
            console.log(response);
            
            alert(response.data.message);
            this.users.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting user");
          });
      }
    },
    getEmployer(){
        
      axios
        .get("/api/employer/getEmployer")
        .then((response) => {
            
          this.employes = response.data;

          console.log(response);
          
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error.data);
        });

    },
  },
  
};
</script>

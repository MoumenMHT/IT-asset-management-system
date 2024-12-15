<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          
          <form class="row g-3" @submit.prevent="submitForm">
            <!-- Employee Section -->
            <div class="row">
              <div class="col-md-6">
                <h5 class="card-title">Select Employer</h5>
                <!-- Employee Name -->
                
          
                <!-- Employee Code -->
                <div class="mb-3">
                  <label class="form-label">Employee Code</label>
                  <v-autocomplete
                    v-model="selectedEmployee"
                    :items="employes"
                    item-title="code"
                    label="Code"
                    variant="outlined"
                    return-object
                    
                    
                  >
                  <template v-slot:item="{ props, item }">
                    <v-list-item
                      v-bind="props"
                      :subtitle="`Prenom: ${item.raw.prenom} - Nom: ${item.raw.nom} - Structure: ${item.raw.structure} - Fonction: ${item.raw.fonc}`"
                      :title="item.raw.code"
                    ></v-list-item>
                  </template>
               
                  </v-autocomplete>
                </div>
                <div class="mb-3">
                  <label class="form-label">Nom</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.nom :''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Prenom</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.prenom :''"
                    readonly
                  />
                </div>
          
                <!-- Fonction -->
                <div class="mb-3">
                  <label class="form-label">Fonction</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.fonc :''"
                    readonly
                  />
                </div>
          
                <!-- Structure -->
                <div class="mb-3">
                  <label class="form-label">Structure</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.structure :''"
                    readonly
                  />
                </div>
              </div>
          
              <!-- Equipment Section -->
              <div class="col-md-6">
                <h5 class="card-title">Select Equipment</h5>
            
                <!-- Filter by Type -->
                <div class="mb-3">
                  <label class="form-label">Filter by Type</label>
                  <v-select
                    v-model="selectedType"
                    :items="equipments.map(item => item.Type).filter((value, index, self) => self.indexOf(value) === index)" 
                    label="Type"
                    placeholder="Select a type"
                    @change="filterEquipmentsByType"
                  >
                  <template v-slot:prepend-item>
                    <v-list-item ripple @click="selectNoFilter">
                      <v-list-item>
                        <v-list-item-title>No Filter</v-list-item-title>
                      </v-list-item>
                    </v-list-item>
                  </template>
                </v-select>
                </div>
              
                <!-- Equipment Autocomplete -->
                <div class="mb-3">
                  <label class="form-label">Equipment Code Bar</label>
                  <v-autocomplete
                    v-model="selectedEquipment"
                    :items="filteredEquipments"
                    item-title="num_serie"
                    label="Num Serie"
                    variant="outlined"
                    return-object
                  >
                  <template v-slot:item="{ props, item }">
                    <v-list-item
                      v-bind="props"
                      :subtitle="`Type: ${item.raw.Type} - Marque: ${item.raw.marque} - Etat: ${item.raw.etat} - Date D'amortissement: ${item.raw.date_amortissement}`"
                      :title="item.raw.num_serie"
                    ></v-list-item>
                  </template>
                </v-autocomplete>
                </div>
              
                <!-- Equipment Details -->
                <div class="mb-3">
                  <label class="form-label">Type</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.Type : ''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Marque</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.marque : ''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Etat</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.etat : ''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Date D'amortissement</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.date_amortissement : ''"
                    readonly
                  />
                </div>
            </div>
            
            </div>
          
            <!-- Buttons -->
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
                <th>Code D'employer</th>
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
      selectedEmployee: null,
      selectedEquipment: null, 
      selectedType: 'defaultType',
      filteredEquipments: [],
      
      form: {
            username: '',
            password: '',
            type: '',
            employer: '',
        },
      users: [],
      employes: [],
      equipments: [],
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
    this.filteredEquipments = this.equipments;

    this.fetchUsers();
    this.getEmployer();
    this.getEquipment();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  methods: {


    selectNoFilter() {
      // Manually set the selectedType to null for "No Filter"
      this.selectedType = null;
    },

    filterEquipmentsByType() {
    // Filter logic here
    if (this.selectedType) {
      this.filteredEquipments = this.equipments.filter(equipment => equipment.Type === this.selectedType);
    } else {
      this.filteredEquipments = this.equipments;
    }
  },

 

    

    


    fetchUsers() {
      axios
        .get("/user/getUser")
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
       
        const data = { 
          id_employer: this.selectedEmployee.id, 
          id_equipement: this.selectedEquipment.id 
        };
        console.log(data);


        if (data.id_employer && data.id_equipement) {

          axios.post('/History', data)
                .then(response => {
                  if(response.data.message){

                    alert(response.data.message);
                    console.log(response.data.id);
                    const affectationId = response.data.id;
                    console.log('Calling generatePdf with ID:', affectationId);
                    this.generatePdf(affectationId);
                  }else if(response.data.error) {
                    alert(response.data.error);
                  }
                    
                })
                .catch(error => {
                    console.log(error);
                    
                });

        }else{
          alert('Please select an employer and an equipement');
        }
            
            
},
generatePdf(affectationId) {
    console.log('Generating PDF for affectation ID:', affectationId);
    // Trigger the PDF download
    window.location.href = `/generate-pdf/${affectationId}`;
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
            .put(`/userCrud/${id}`, updateduser)
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
          .delete(`/userCrud/${id}`)
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
        .get("/employer/getEmployer")
        .then((response) => {
            
          this.employes = response.data;
          console.log(this.employes);
          
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error.data);
        });

    },
    getEquipment() {       
        axios
            .get("/equipment/getEquipment")
            .then((response) => {
                // Filter only available equipment
                this.equipments = response.data.filter((item) => item.status === 'disponible');
                
                // Initialize the filtered list with all available equipment
                this.filteredEquipments = this.equipments;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },

  },

  watch: {
  selectedType(newType) {
    this.filterEquipmentsByType();
  }
}
  
};
</script>

<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">User Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            
            
            <div class="col-12">
                  <label class="form-label">Select employee</label>                 
                  <v-autocomplete
                    v-model="form.employer"
                    :items="employes"
                    item-title="code"
                    label="Code"
                    variant="outlined"
                    
                    
                    
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
            <v-data-table
            :headers="headers"
            :items="users"
            :sort-by="[{ key: 'created_at', order: 'desc' }]"
          >
            <template v-slot:top>
              <v-toolbar
                flat
              >
                  <v-toolbar-title>Structures Table</v-toolbar-title>
                
                  <v-dialog
                    v-model="dialog"
                    max-width="500px"
                  >
                  
                  <v-card>
                    <v-card-title>
                      <span class="text-h5">{{ formTitle }}</span>
                    </v-card-title>

                    <v-card-text>
                      <v-container>
                        <v-row>
                          
                          
                          <v-col
                          cols="12"
                            md="4"
                            sm="6"
                          >
                          <v-text-field
                              v-model="editedItem.username"
                              label="Username"
                            ></v-text-field>
                          </v-col>
                          <v-col
                          cols="12"
                            md="4"
                            sm="6"
                          >
                          <v-text-field
                              v-model="editedItem.password"
                              label="Password"
                            ></v-text-field>
                          </v-col>
                          <v-col
                          cols="12"
                            md="4"
                            sm="6"
                          >
                          <v-select
                            label="Select"
                            v-model="editedItem.type"
                            :items="['admin', 'worker', 'viewer']"
                          ></v-select>
                          </v-col>
                          
                          
                        </v-row>
                      </v-container>
                    </v-card-text>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="close"
                      >
                        Cancel
                      </v-btn>
                      <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="save"
                      >
                        Save
                      </v-btn>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="500px">
                  <v-card>
                    <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="blue-darken-1" variant="text" @click="closeDelete">Cancel</v-btn>
                      <v-btn color="blue-darken-1" variant="text" @click="deleteItemConfirm">OK</v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
              <v-icon
                class="me-2"
                size="small"
                @click="editItem(item)"
              >
                mdi-pencil
              </v-icon>
              <v-icon
                size="small"
                @click="deleteItem(item)"
              >
                mdi-delete
              </v-icon>
            </template>
            <template v-slot:no-data>
              <v-btn
                color="primary"
                @click="initialize"
              >
                Reset
              </v-btn>
            </template>
          </v-data-table>


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

      dialog: false,
      dialogDelete: false,
      editedIndex: -1,
      editedItem: {
        name: '',

      },
      defaultItem: {
        name: '',

      },
      headers:[
      { title: 'Code', key:'code' },
      { title: 'Username', key:'username' },
      { title: 'Password', key:'password' },
      { title: 'Type', key:'type' },
      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],

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
  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit User'
        },
      },
  methods: {

    closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

    deleteItem (item) {
        this.editedIndex = this.users.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.users.indexOf(item)
        this.editedItem = Object.assign({}, item)
        console.log('sfaffd', this.editedIndex);
        
        this.dialog = true
      },
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

    
    fetchUsers() {
      axios
        .get("/api/user/getUser")
        .then((response) => {
          this.users = response.data;
          
          console.log(response);
          
          
          
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
            console.log('before sending',this.form);
            
            axios.post('/api/userCrud', this.form)
                .then(response => {
                    // Handle successful registration
                    alert(response.data.message);
                    console.log(response.data.debug);
                    const insertedData = response.data.data;

                    console.log(insertedData);  
                    this.users.unshift(insertedData);
                    
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
    save() {  
        let updateduser = this.editedItem;
       
        console.log('Updated user Before Sending:', updateduser);
        
        const id = updateduser.id;
        const index = this.editedIndex;
        

        axios
            .put(`/api/userCrud/${id}`, updateduser)
            .then((response) => {
              
            alert(response.data.message);
            console.log(response);
            
            
            Object.assign(this.users[index], response.data.user);
            
            
            })
            .catch((error) => {
            alert("Error updating user");
            console.log(error);
        });
        this.close();
    },
    cancelEdit() {
      this.editRow = null;
      this.editableuser = {}; // Clear the temporary storage
    },
    deleteItemConfirm() {
      const id = this.editedItem.id;
        const index = this.editedIndex;
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
          this.closeDelete();
      
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

<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Employer Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            <div class="col-12">
              <label for="inputNanme4" class="form-label"> Employer First Name</label>
              <input type="text" v-model="form.prenom" class="form-control" />
            </div>

            <div class="col-12">
              <label for="inputNanme4" class="form-label"> Employer Last Name</label>
              <input type="text" v-model="form.nom" class="form-control" />
            </div>
            
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Function </label>
              <input type="text" v-model="form.fonc" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Code</label>
              <input type="text" v-model="form.code" class="form-control" />
            </div>
            <div class="col-12">
                  <label class="form-label">Select Structure</label>                 
                    <select class="form-select" aria-label="Default select example" v-model="form.structure" >
                      <option value="" disabled>Select a Structure</option>
                      <option v-for="structure in structures" :key="structure.id" :value="structure.nom">
                        {{ structure.nom }}
                      </option>
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
          <h5 class="card-title">All employers</h5>
          <div id="Table">
            <v-data-table
            :headers="headers"
            :items="employers"
            :search="search"
            :sort-by="[{ key: 'created_at', order: 'desc' }]"
          >
  <template v-slot:top>
    <v-toolbar
      flat
    >
    <v-text-field
    v-model="search"
    label="Search"
    prepend-inner-icon="mdi-magnify"
  >
  </v-text-field> 
     
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
                    v-model="editedItem.prenom"
                    label="First Name"
                  ></v-text-field>
                </v-col>
                <v-col
                cols="12"
                  md="4"
                  sm="6"
                >
                <v-text-field
                    v-model="editedItem.nom"
                    label="Name"
                  ></v-text-field>
                </v-col>
                <v-col
                cols="12"
                  md="4"
                  sm="6"
                >
                <v-text-field
                    v-model="editedItem.fonc"
                    label="Fonction"
                  ></v-text-field>
                </v-col>
                <v-col
                cols="12"
                  md="4"
                  sm="6"
                >
                <v-text-field
                    v-model="editedItem.code"
                    label="Code"
                  ></v-text-field>
                </v-col>
                <v-col
                cols="12"
                  md="4"
                  sm="6"
                >
                <v-text-field
                    v-model="editedItem.structure"
                    label="Structure"
                  ></v-text-field>
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
      search:'',
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
      { title: 'First Name', key:'prenom' },
      { title: 'Name', key:'nom' },
      { title: 'Fonction', key:'fonc' },
      { title: 'Code', key:'code' },
      { title: 'Structure', key:'structure' },

      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],

      form: {
        nom: "",
        prenom: "",
        fonc: "",
        code: "",
        structure: "",

      },
      employers: [],
      structures: [],
      name: '',
      editRow: null, // To track the row being edited
      editableemployer: {
        nom: "",
        prenom: "",
        fonc: "",
        code: "",
        structure: "",
      }, // To temporarily store the editable employer data
    };
  },
  mounted() {
    this.fetchemployers();
    this.getStructure();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit Employer'
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
        this.editedIndex = this.employers.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.employers.indexOf(item)
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

    fetchemployers() {
      axios
        .get("/api/employer/getEmployer")
        .then((response) => {
          this.employers = response.data;
          
          console.log(response.data);
          if(this.employers){
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
      console.log(this.form);
      
      axios
        .post("/api/employe", this.form)
        .then(response => {
          console.log(response.data);
            alert('employer inserted successfully');
            const insertedData = response.data.data;

            console.log(insertedData);

            this.employers.unshift(insertedData);
            
            this.ref = '';
            this.employer = '';
            this.stremployer = '';
        })
        .catch((error) => {
          alert("Error submitting form");
        });
    },
    enableEdit(employer) {
      if (employer && employer.id) {
      this.editRow = employer.id;

      this.editableemployer = { ...employer }; // Store a copy of the employer data
  } else {
    console.log('No valid employer data found!');
  }
    },
    save() {
      if ( !this.editedItem  || !this.editedItem.nom || !this.editedItem.prenom || !this.editedItem.code || !this.editedItem.fonc || !this.editedItem.structure  ) {
        console.error('Error: Missing required fields in editedItem', this.editedItem);
        alert('Please fill in all required fields before saving.');
        return;
      }
        const updatedemployer = this.editedItem;
        
        console.log('Updated employer Before Sending:', updatedemployer);
        
        const id = updatedemployer.id;
        const index = this.editedIndex;
        
        

        axios
            .put(`/api/employe/${id}`, updatedemployer)
            .then((response) => {
              console.log(response);
              
            alert("employer updated successfully");
            
            Object.assign(this.employers[index], response.data.employer);
            
            
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating employer");
            console.log(error);
        });
        this.close();
    },
    cancelEdit() {
      this.editRow = null;
      this.editableemployer = {}; // Clear the temporary storage
    },
    deleteItemConfirm() {
        const id = this.editedItem.id;
        const index = this.editedIndex;
        axios
          .delete(`/api/employe/${id}`)
          .then(() => {
            alert("employer deleted successfully");
            this.employers.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting employer");
          });
      this.closeDelete();
    },
    getStructure(){

      axios
        .get("/api/structure/getStructure")
        .then((response) => {
          this.structures = response.data;
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error.data);
        });

    },
  },
  
};
</script>

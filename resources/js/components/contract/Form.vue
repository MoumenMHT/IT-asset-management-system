<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Contract Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Contract Reference</label>
              <input type="text" v-model="form.ref" class="form-control" />
            </div>

            <div class="col-12">
                  <label class="form-label">Select Fournisseur</label>                 
                    <select class="form-select" aria-label="Default select example" v-model="form.fournisseur" >
                      <option value="" disabled>Select a Provider</option>
                      <option v-for="fournisseur in fournisseurs" :key="fournisseur.id" :value="fournisseur.nom">
                        {{ fournisseur.nom }}
                      </option>
                    </select>  
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
            <div class="col-12">
                  <label class="form-label">Select Type</label>                 
                    <select class="form-select" aria-label="Default select example" v-model="form.Type_contract" >
                      <option value="" disabled>Select a Type</option>
                      <option  >achat</option>
                      <option  >maintenance</option>
                    </select>  
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Date of Acquisition</label>
              <input type="date" v-model="form.date_acquisition" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Guarantee</label>
              <input type="date" v-model="form.garantie" class="form-control" />
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
          <h5 class="card-title">All Contracts</h5>
          <div id="Table">
            <v-data-table
            :headers="headers"
            :items="contracts "
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
                      v-model="editedItem.ref"
                      label="Reference"
                      
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    md="4"
                    sm="6"
                  >
                  <v-select
                    label="Select"
                    v-model="editedItem.fournisseur"
                    :items="fournisseurs"
                    item-title="nom"
                  ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    md="4"
                    sm="6"
                  >
                  <v-select
                    label="Select"
                    v-model="editedItem.structure"
                    :items="structures"
                    item-title="nom"
                  ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    md="4"
                    sm="6"
                  >
                  <v-select
                    label="Select"
                    v-model="editedItem.Type_contract"
                    :items="['achat', 'maintenance']"
                  ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    md="4"
                    sm="6"
                  >
                  <v-text-field
                    v-model="editedItem.garantie"
                    label="Guarantee"
                    type="date"
                  ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                    md="4"
                    sm="6"
                  >
                    <v-text-field
                      v-model="editedItem.date_acquisition"
                      label="Acquisition Date"
                      type="date"
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
        ref: '',
        fournisseur:'',
        structure:'',
        Type_contract:'',
        garantie:'',
        date_acquisition:'',
      },
      defaultItem: {
        ref: '',
        fournisseur:'',
        structure:'',
        Type_contract:'',
        garantie:'',
        date_acquisition:'',
      },
      headers:[
      { title: 'Reference', key:'ref' },
      { title: 'Provider', key:'fournisseur' },
      { title: 'Structure', key:'structure' },
      { title: 'Type Contract', key:'Type_contract' },
      { title: 'Guarantee', key:'garantie' },
      { title: 'Acquisition Date  ', key:'date_acquisition' },
      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],

      form: {
        ref: "",
        structure	: "",
        fournisseur : "",
        date_acquisition: "",
        garantie:"",
        Type_contract:""
      },
      contracts: [],
      structures: [],
      fournisseurs: [],
      name: '',
      editRow: null, // To track the row being edited
      editableContract: {
        ref: "",
        structure	: "",
        fournisseur : "",
        date_acquisition: "",
        garantie:"",
        Type_contract:""
      }, // To temporarily store the editable contract data
    };
  },
  mounted() {
    this.fetchContracts();
    this.getStructure();
    this.getFournisseur();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
    const queryParams = new URLSearchParams(window.location.search);
    this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit Contract'
        },
      },
  methods: {

    close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.contracts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        console.log('sfaffd', this.editedIndex);
        
        this.dialog = true
      },

    fetchContracts() {
      // Retrieve the token from localStorage or sessionStorage
    const token = localStorage.getItem('auth_token'); // Adjust this based on where you store the token

// Log the token to the console
console.log('Token:', token);
      axios
        .get("/api/contracts/getContracts", {
            headers: {
                'Authorization': `Bearer ${token}` // Use template literals correctly
            },
            withCredentials: true
        })
        .then((response) => {
          this.contracts = response.data;
          
          console.log(response.data);
          if(this.contracts){
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
      console.log('here');
      tableRef.DataTable({
        paging: true,
        searching: true,
        responsive: true,
      });
    },
    submitForm() {
      console.log(this.form);
      
      axios
        .post("/api/contract", this.form)
        .then(response => {
          console.log(response);
            alert('Contract inserted successfully');

            const insertedData = response.data.data;
            this.contracts.unshift(insertedData);


           console.log(insertedData);
           

            this.ref = '';
            this.fournisseur = '';
            this.strContract = '';
        })
        .catch((error) => {
          alert("Error submitting form");
          console.log(error.data);
        });
    },
    deleteItem (item) {
        this.editedIndex = this.contracts.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

    save() {

      if ( !this.editedItem || !this.editedItem.ref || !this.editedItem.fournisseur || !this.editedItem.structure || !this.editedItem.Type_contract || !this.editedItem.garantie || !this.editedItem.date_acquisition) {
        console.error('Error: Missing required fields in editedItem', this.editedItem);
        alert('Please fill in all required fields before saving.');
        return;
      }

        const updatedContract = this.editedItem;
        console.log('Updated Contract Before Sending:', updatedContract);
        console.log(this.editedIndex);
        const id = updatedContract.id
        const index = this.editedIndex;
        
        

        axios
            .put(`/api/contract/${id}`, updatedContract)
            .then((response) => {
              console.log(response);
              
            alert("Contract updated successfully");
            Object.assign(this.contracts[index], updatedContract);

            })
            .catch((error) => {
            alert("Error updating contract");

            
            console.log(error);
        });
        this.close();
    },
    cancelEdit() {
      this.editRow = null;
      this.editableContract = {}; // Clear the temporary storage
    },
    deleteItemConfirm () {
      const index = this.editedIndex;
      const id = this.editedItem.id;
        axios
          .delete(`/api/contract/${id}`)
          .then(() => {
            alert("Contract deleted successfully");
            this.contracts.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting contract");
          });
          this.closeDelete();
      
    },
    getStructure(){
      // Retrieve the token from localStorage or sessionStorage
    const token = localStorage.getItem('auth_token'); // Adjust this based on where you store the token

// Log the token to the console
console.log('Token:', token);

      axios
        .get("/api/structure/getStructure", {
            headers: {
                'Authorization': `Bearer ${token}` // Use template literals correctly
            },
            withCredentials: true
        })
        .then((response) => {
          this.structures = response.data;
          console.log('structure ', response);
          
          
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error.data);
        });

    },
    getFournisseur(){

      axios
        .get("/api/provider/getProvider")
        .then((response) => {
          this.fournisseurs = response.data;
          
        })
        .catch((error) => {
          console.error("Error fetching data:", error.data);
        });

    },
  },
  
};
</script>

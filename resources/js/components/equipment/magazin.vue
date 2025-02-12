<template>
  
    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">


        <div class="card-body">
          <h5 class="card-title">Add a new equipment </h5>
          <form class="row g-3" @submit.prevent="submitForm">
            <div class="col-12">
              <label for="inputNanme4" class="form-label">serial number</label>
              <input type="text" v-model="form.num_serie" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Contract</label>
              <v-autocomplete
                    v-model="form.contract"
                    :items="contracts"
                    item-title="ref"
                    label="Code"
                    variant="outlined"
                    
                  >
                  </v-autocomplete>
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Type</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.Type" >
                    <option value="" disabled>Select a Type</option>
                    <option  >PC</option>
                    <option  >Monitor</option>
                    <option  >Printer</option>
                    <option  >Mouse</option>
                    <option  >Keyboard</option>
                    <option  >Laptop</option>
                    <option  >All in one</option>

                  </select>
            </div>
            <div class="col-12">
              <label for="inputPassword4" class="form-label">Brand</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.marque" >
                    <option value="" disabled>Select a Brand</option>
                    <option v-for="fournisseur in fournisseurs" :key="fournisseur.id" :value="fournisseur.nom" >
                      {{ fournisseur.nom }}
                  </option>                  </select>
            </div>
            
            <div class="col-12">
              <label for="inputPassword4" class="form-label">Condition</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.etat" >
                    <option value="" disabled>Select a Etat</option>
                    <option>New</option>
                    <option>Used</option>
                  </select>
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">amortization date</label>
              <input type="date" v-model="form.date_amortissement" class="form-control" />
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
            :items="equipments"
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
                    v-model="editedItem.num_serie"
                    label="Serial Number"
                  ></v-text-field>
                </v-col>
                <v-col
                  cols="32"
                  md="24"
                  sm="6"
                >
                <v-autocomplete
                    v-model="editedItem.contractRef"
                    :items="contracts"
                    item-title="ref"
                    label="Reference"
                    
                  >
                  </v-autocomplete>
                </v-col>
                <v-col
                  cols="12"
                  md="4"
                  sm="6"
                >
                <v-select
                label="Select"
                v-model="editedItem.Type"
                :items="['PC', 'Monitor','Printer','Mouse','Keyboard','Laptop','All in one']"
              ></v-select>
                </v-col>
                <v-col
                  cols="12"
                  md="4"
                  sm="6"
                >
                <v-select
                label="Select"
                v-model="editedItem.marque"
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
                v-model="editedItem.etat"
                :items="['New', 'Used']"
              ></v-select>
                </v-col>
                
                <v-col
                  cols="12"
                  md="4"
                  sm="6"
                >
                  <v-text-field
                    v-model="editedItem.date_amortissement"
                    label="amortization date"
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
      { title: 'Serial Number', key:'num_serie' },
      { title: 'Contract', key:'contract.ref' },
      { title: 'Type', key:'Type' },
      { title: 'Brand', key:'marque' },
      { title: 'Condition', key:'etat' },
      { title: 'Status', key:'status' },
      { title: 'amortization date', key:'date_amortissement' },

      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],
      form: {
        num_serie: "",
        contract:"",
        Type: "",
        marque: "",
        etat: "",
        date_amortissement: "",
      },
      equipments: [],
      contracts:[],
      fournisseurs:[],
      editRow: null, // To track the row being edited
      editableEquipment: {
        num_serie: "",
        Type: "",
        marque: "",
        etat: "",
        status: "",
        date_amortissement: "",
      }, // To temporarily store the editable equipment data
    };
  },
  mounted() {
    this.getContract();
    this.fetchEquipments();
    this.getFournisseur();
  },
  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit Equipment'
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
        this.editedIndex = this.equipments.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.equipments.indexOf(item)
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

    fetchEquipments() {
      axios
        .get("/api/equipment/getEquipment")
        .then((response) => {
          this.equipments = response.data || []; 
          console.log(response);
          
          this.$nextTick(() => {
            this.initializeDataTable();
          });
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
      
      axios
        .post("/api/equipment", this.form)
        .then(response => {
          
            alert('Equipment inserted successfully');

            const insertedData = response.data.data;

            console.log(insertedData);
            
            this.equipments.unshift(insertedData);


            
        })
        .catch((error) => {
          alert("Error submitting form");
        });
    },
    enableEdit(equipment) {
      if (equipment && equipment.id) {
    this.editRow = equipment.id;

    this.editableContract = { ...equipment }; // Store a copy of the contract data
  } else {
    console.log('No valid contract data found!');
  }
    },
    save() {

      if ( !this.editedItem  || !this.editedItem.contractRef || !this.editedItem.num_serie || !this.editedItem.Type || !this.editedItem.marque || !this.editedItem.etat || !this.editedItem.status || !this.editedItem.date_amortissement ) {
        console.error('Error: Missing required fields in editedItem', this.editedItem);
        alert('Please fill in all required fields before saving.');
        return;
      }

        const updatedEquipment = this.editedItem;
        const index = this.editedIndex;
        
        const id = updatedEquipment.id;
        console.log('Updated Contract Before Sending:', updatedEquipment);
        

        axios
            .put(`/api/equipment/${id}`, updatedEquipment)
            .then((response) => {
              console.log(this.equipments);
              
            alert("Contract updated successfully");
            Object.assign(this.equipments[index], response.data.equipment);
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
    deleteItemConfirm() {

      const id = this.editedItem.id;
      const index = this.editedIndex;

        axios
          .delete(`/api/equipment/${id}`)
          .then((response) => {
            alert("Contract deleted successfully");
            this.equipments.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting contract");
          });
      this.closeDelete();
    },
    getContract(){

      axios
        .get("/api/contracts/getContracts")
        .then((response) => {
          this.contracts = response.data;
          console.log(this.contracts);
          
          
          
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

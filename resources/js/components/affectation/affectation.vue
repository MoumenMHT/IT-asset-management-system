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
                  <label class="form-label">First Name</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.prenom :''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Last Name</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEmployee ? selectedEmployee.nom :''"
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
                  <label class="form-label">Filter by Euipment Type</label>
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
                  <label class="form-label">Equipment serial number</label>
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
                  <label class="form-label">Brand</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.marque : ''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">Condition</label>
                  <input
                    type="text"
                    class="form-control"
                    :value="selectedEquipment ? selectedEquipment.etat : ''"
                    readonly
                  />
                </div>
                <div class="mb-3">
                  <label class="form-label">amortization date</label>
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
          <h5 class="card-title">All historys</h5>
          <div id="Table">
           
  <v-data-table
    :headers="headers"
    :items="historys"
    :sort-by="[{ key: 'created_at', order: 'des' }]"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >
        <v-toolbar-title>Equipments History</v-toolbar-title>
        
        <v-spacer></v-spacer>
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
                    cols="22"
                    md="14"
                    sm="6"
                  >
                  <v-select
                    label="Select"
                    v-model="editedItem.type"
                    :items="['assignment', 'restitution']"
                  ></v-select>
                  </v-col>
                  <v-col
                    cols="12"
                    md="14"
                    sm="6"
                  >
                  <v-autocomplete
                    v-model="editedItem.employer"
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
                  </v-col>
                  <v-col
                    cols="12"
                    md="14"
                    sm="6"
                  >
                  <v-autocomplete
                    v-model="editedItem.equipement"
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
    <template v-slot:item.actions="{ item, index }">
  <!-- Edit Icon -->
  <v-icon
    class="me-2"
    size="small"
    @click="editItem(item)"
  >
    mdi-pencil
  </v-icon>
  &nbsp;

  <!-- File Upload/Update and Download Icons -->
  <template v-if="item.status === 'en attente'">
    <v-icon
      class="me-2"
      size="small"
      @click="triggerFileInput(index, item)"
    >
      mdi-upload
    </v-icon>
    &nbsp;
  </template>
  <template v-else>
    <button 
      @click="triggerFileInput(index, item)" 
      class="btn btn-warning btn-sm"
    >
      Update file
    </button>
    &nbsp;
    <v-icon
      v-if="item.path"
      class="me-2"
      size="small"
      @click="downloadFile(`/storage/${item.path}`)"
    >
      mdi-download
    </v-icon>
  </template>

  <!-- Hidden File Input -->
  <input
    type="file"
    :ref="'fileInput-' + index"
    style="display: none"
    @change="(event) => handleFileUpload(event, item)"
  />
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
import { reactive } from 'vue'; // Import reactive for Vue 3


export default {
  setup() {
    // Use reactive to make the object a proxy
    const editedItem = reactive({
      employer: null, // This will hold the selected employer object (as a proxy)
    });
  },

  data() {
    return {
      dialog: false,
      dialogDelete: false,
      editedIndex: -1,
      editedItem: {

      },
      defaultItem: {
       

      },
      headers:[
      { title: 'Type', key:'type' },
      { title: 'Employer Code', key:'employer.code' },  // Nested value for employer code
      { title: 'Siryal Number', key:'equipement.num_serie' },  // Nested value for equipment serial number
      { title: 'Status', key:'status' },
      { title: 'Created at', key:'created_at' },
      { title: 'Updated at', key:'updated_at' },
      { title: 'Actions', key: 'actions', sortable: false },

      ],

      selectedFile: null, // Store the uploaded file
      historyId: null, // Store the ID of the history for the file upload
      selectedEmployee: null,
      selectedEquipment: null, 
      selectedType: 'defaultType',
      filteredEquipments: [],

      historys: [],
      employes: [],
      equipments: [],
      name: '',
      editRow: null, // To track the row being edited
      editablehistory: {
            type: '',
            employer: '',
            equipement: '',
      }, // To temporarily store the editable history data
      
      
    };
    
    
  },

  

  mounted() {
    this.filteredEquipments = this.equipments;

    this.fetchHistorys();
    this.getEmployer();
    this.getEquipment();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },

  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
        },
      },
  methods: {


    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.historys.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialog = true
      },
      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

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

 

    

    


  fetchHistorys() {
  axios
    .get("/api/history/getHistory")
    .then((response) => {
      this.historys = response.data;

      console.log('history', this.historys);
      
      // Check if the data is non-empty
      if (this.historys && this.historys.length > 0) {
        const tableRef = $(this.$refs.datatable);

        // Only initialize or re-initialize if the table is not already initialized
        if ($.fn.DataTable.isDataTable(this.$refs.datatable)) {
          tableRef.DataTable().clear().destroy();
        }

        this.$nextTick(() => {
          this.initializeDataTable(); // Initialize after the DOM is updated
        });
      } else {
        console.log('No data available, DataTable not initialized');
      }
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
    });
},

initializeDataTable() {
  const tableRef = $(this.$refs.datatable);

  // Check if DataTable is already initialized
  if ($.fn.DataTable.isDataTable(this.$refs.datatable)) {
    // If DataTable is already initialized, clear it and destroy it
    tableRef.DataTable().clear().destroy();
  }

  // Initialize DataTable with new data
  tableRef.DataTable({
    paging: true,
    searching: true,
    responsive: true,
    data: this.historys, // Pass the correct structure to DataTable
    columns: [
      { data: (row, type, set, meta) => meta.row + 1 }, // Display index as number
      { data: 'type' },
      { data: 'employer.code' },  // Nested value for employer code
      { data: 'equipement.num_serie' },  // Nested value for equipment serial number
      { data: 'status' },
      { data: 'created_at' },
      { data: 'updated_at' },
    ],
    "processing": true,
    "stateSave": true, // Save state to prevent re-initialization issues
    "error": function (e, settings, techNote, message) {
      // Custom handling: stop the alert from being shown
      console.error("DataTable Error:", message); // Log to console, but don't show alert
    },
    "initComplete": function(settings, json) {
      // Prevent the error popup from showing
      $('.dataTables_wrapper .dataTables_info').hide();
    }
 
  });
},

      submitForm() {
       
        const data = { 
          employer: { id_employer: this.selectedEmployee.id },
          equipement: {id_equipement: this.selectedEquipment.id }
        };
        console.log(data);


        if (data.employer && data.equipement) {

          axios.post('/api/History', data)
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
      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
      

    enableEdit(history) {
      if (history && history.id) {
      this.editRow = history.id;

      this.editablehistory = { ...history }; // Store a copy of the history data
  } else {
    console.log('No valid history data found!');
  }
    },
    save() {
      console.log('id is ', this.editedItem );
      this.historys.unshift(this.editedItem);
      let index = this.editedIndex;
      let id = this.historys[this.editedIndex].id;
      
        let updatedhistory =this.editedItem;
        if (updatedhistory.employer.id) {
            updatedhistory.employer.id_employer = updatedhistory.employer.id;
        }        if (updatedhistory.equipement.id) {
            updatedhistory.equipement.id_equipement = updatedhistory.equipement.id;
        }

        console.log('Updated history Before Sending:', updatedhistory);

        

        axios
            .post(`/api/History`, updatedhistory)
            .then((response) => {
              
                alert(response.data.message);
                console.log(response.data);

                this.historys[index].password = response.data.history;
                
                this.editRow = null; // Exit editing mode
                this.getEquipment; 
                console.log(response);
                
                const affectationId = response.data.id;
                
                //this.generatePdf(affectationId);
               
              
           
            })
            .catch((error) => {
            alert("Error updating history");
            console.log(error);
        });
        this.close()
    },
    cancelEdit() {
      this.editRow = null;
      this.editablehistory = {}; // Clear the temporary storage
    },
    deletehistory(id, index) {
      if (confirm("Are you sure you want to delete this history?")) {
        axios
          .delete(`/api/historyCrud/${id}`)
          .then((response) => {
            console.log(response);
            
            alert(response.data.message);
            this.historys.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting history");
          });
      }
    },
    getEmployer(){
        
      axios
        .get("/api/employer/getEmployer")
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
            .get("/api/equipment/getEquipment")
            .then((response) => {
              console.log(response);
              
                // Filter only available equipment
                this.equipments = response.data.filter((item) => item.status === 'disponible');
                
                // Initialize the filtered list with all available equipment
                this.filteredEquipments = this.equipments;
            })
            .catch((error) => {
                console.error("Error fetching data:", error);
            });
    },
     // Show file input and store the history ID

triggerFileInput(index, id) {
  
    this.historyId = id.id; // Save the history ID
    const fileInput = this.$refs[`fileInput-${index}`]; // Access the specific input by index

    if (fileInput && fileInput.length > 0) {
      fileInput[0].click(); // Trigger the file input (if it returns an array)
    } else if (fileInput) {
      fileInput.click(); // Trigger the file input directly
    } else {
      console.error("File input element not found or invalid.");
    }
  },

    // Handle file selection
    handleFileUpload(event, id) {

      id = this.historyId;
      console.log('id',id);

      const file = event.target.files[0]; // Get the selected file
      if (!file) {
        alert("No file selected!");
        return;
      }

      this.uploadFile(file, id);
    },

    // Upload the file to the backend using Axios
    async uploadFile(file, id) {
  const reader = new FileReader();
  
  reader.onload = async (e) => {
    const base64File = e.target.result;

    try {
      // Make PUT request with the correct payload
      const response = await axios.put(`/api/History/${id}`, {
        file: base64File, // Ensure "file" matches Laravel validation rule
      });

      console.log("File uploaded successfully:", response.data);
      alert("File uploaded successfully!");
      this.fetchHistorys();
    } catch (error) {
      if (error.response && error.response.data) {
        console.error("Error uploading file:", error.response.data);
        alert(`File upload failed: ${error.response.data.message}`);
      } else {
        console.error("Error uploading file:", error);
        alert("File upload failed!");
      }
    }
  };

  reader.onerror = (error) => {
    console.error("Error converting file to Base64:", error);
    alert("File processing failed!");
  };

  reader.readAsDataURL(file); // Read the file as Base64
},
downloadFile(filePath) {
    const link = document.createElement('a');
    link.href = filePath; // Use the relative URL
    link.download = ''; // Let the browser handle the file name
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  }



  },


  watch: {
  selectedType(newType) {
    this.filterEquipmentsByType();
  }
}
  
};
</script>
<style scoped>
/* Hide DataTables warning */
div.dataTables_wrapper .dataTables_info,
div.dataTables_wrapper .dataTables_length,
div.dataTables_wrapper .dataTables_filter,
div.dataTables_wrapper .dataTables_paginate,
div.dataTables_wrapper .dataTables_empty,
div.dataTables_wrapper .dataTables_error {
  display: none !important;
}

</style>

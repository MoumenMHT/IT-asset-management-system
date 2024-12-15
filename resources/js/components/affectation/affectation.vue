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
          <h5 class="card-title">All historys</h5>
          <div id="Table">
           <table class="table datatable" ref="datatable">
            <thead>
              <tr>
                <th>Num</th>
                <th>Type</th>
                <th>Employer</th>
                <th>Eauipement</th>
                <th>Créé à</th>
                <th>Mis à jour à</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display message when no historys are available -->
              <tr v-if="historys.length === 0">
                <td colspan="7" class="text-center">No historys available.</td>
              </tr>

              <!-- Loop through historys -->
              <tr v-for="(history, index) in historys" :key="history.id">
                <!-- Editable Row -->
                <template v-if="editRow === history.id">
                  <td>{{ index + 1 }}</td>
                  
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="editablehistory.type" >
                      <option value="" disabled>{{history.type}}</option>
                      <option  >affectation</option>
                      <option  >desaffectation</option>
                    </select>
                  </td>
                  <td>
                    <v-autocomplete
                    v-model="editablehistory.code"
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
                  </td>
                
                  
                  <td>
                    <v-autocomplete
                    v-model="editablehistory.equipement"
                    :items="filteredEquipments"
                    item-title="num_serie"
                    label="Num Serie"
                    variant="outlined"
                  >
                  <template v-slot:item="{ props, item }">
                    <v-list-item
                      v-bind="props"
                      :subtitle="`Type: ${item.raw.Type} - Marque: ${item.raw.marque} - Etat: ${item.raw.etat} - Date D'amortissement: ${item.raw.date_amortissement}`"
                      :title="item.raw.num_serie"
                    ></v-list-item>
                  </template>
                </v-autocomplete>
                  </td>
                  <td>
                    {{ history.created_at }}
                  </td>
                  <td>
                    {{ history.updated_at }}
                  </td>
                  
                  <td>
                    <button
                      @click="confirmEdit(history.id, index)"
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
                  <td>{{ history.type }}</td>
                  <td>{{ history.code }}</td>
                  <td>{{ history.equipement }}</td>
                  <td>{{ history.created_at }}</td>
                  <td>{{ history.updated_at }}</td>

                  <td>
                    <button
                      @click="enableEdit(history)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deletehistory(history.id, index)"
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

 

    

    


    fetchHistorys() {
      axios
        .get("/history/getHistory")
        .then((response) => {
          this.historys = response.data;
          
          console.log(response.data);
          if(this.historys){
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

    enableEdit(history) {
      if (history && history.id) {
      this.editRow = history.id;

      this.editablehistory = { ...history }; // Store a copy of the history data
  } else {
    console.log('No valid history data found!');
  }
    },
    confirmEdit(id, index) {
        let updatedhistory = this.editablehistory;
       
        console.log('Updated history Before Sending:', updatedhistory);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/History/${id}`, updatedhistory)
            .then((response) => {
              
                alert(response.data.message);
                console.log(response.data);
            
                this.historys[index] = { ...updatedhistory }; // Update history in the historys array
                this.historys[index].password = response.data.history;
                
                this.editRow = null; // Exit editing mode
                this.getEquipment; 
                
                

                this.generatePdf(id);
               
              
           
            })
            .catch((error) => {
            alert("Error updating history");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editablehistory = {}; // Clear the temporary storage
    },
    deletehistory(id, index) {
      if (confirm("Are you sure you want to delete this history?")) {
        axios
          .delete(`/historyCrud/${id}`)
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

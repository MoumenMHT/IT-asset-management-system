<template>
  <div class="row">
    <div class="col-lg-6">
      <div class="row">
        <!-- eqipement dissponible Card -->
        <div class="col-xxl-12 col-md-6">
          <div class="card info-card sales-card">
            
            <div class="card-body">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>
                      <a class="dropdown-item" href="#" @click="filterEquepmentByType('All','disponible')">All</a>
                    </h6>
                  </li>
                  <li v-for="(type, index) in uniqueTypes" :key="index">
                    <a class="dropdown-item" href="#" @click="filterEquepmentByType(type,'disponible')">
                      {{ type }}
                    </a>
                  </li>
                </ul>
              </div>
              <h5 class="card-title">Equipment <span>| Available</span></h5>
              <div class="d-flex align-items-center">
                <div
                  class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                >
                <i class=" ri-computer-line"></i>
              </div>
                <div class="ps-3">
                  <h6>{{disponibleCount}}</h6>

                </div>
              </div>
            </div>
          </div>
        </div>
       
        <!-- end eqipement dissponible Card -->
        <!-- eqipement indissponible Card -->
       
        
        <!-- end eqipement indissponible Card -->

        <!-- Other Cards... -->
        
        
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="card-title mb-0">Number of Used Equipment by Structure</h5>
              <a class="btn btn-primary" @click="EquipmentEmployerPieChart('All')">All</a>
            </div>
            <v-autocomplete
              v-model="selectedStructure"
              :items="structures"
              item-title="nom"
              label="Structure"
              variant="outlined"
              return-object
              class="mb-4"
              @update:model-value="() => selectedStructure ? EquipmentEmployerPieChart(selectedStructure.nom) : null"
              ></v-autocomplete>
            <div class="chart-container">
              <canvas id="EquipementEmployerChart"></canvas>
            </div>
          </div>
        </div>
        
        <div class="card recent-sales overflow-auto">
  <div class="filter">
    <a class="icon cursor-pointer" data-bs-toggle="dropdown">
      Structure
    </a>
    &nbsp;
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
      <li class="dropdown-header text-start">
        <h6>
          <a class="dropdown-item" @click="filterContracts('All', 'structure')">All</a>
        </h6>
      </li>
      <li v-for="(structure, index) in structures" :key="index">
        <a class="dropdown-item" @click="filterContracts(structure.nom, 'structure')">
          {{ structure.nom }}
        </a>
      </li>
    </ul>

    <a class="icon cursor-pointer" data-bs-toggle="dropdown">
      Provider
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
      <li class="dropdown-header text-start">
        <h6>
          <a class="dropdown-item" @click="filterContracts('All', 'fournisseur')">All</a>
        </h6>
      </li>
      <li v-for="(fournisseur, index) in fournisseurs" :key="index">
        <a class="dropdown-item" @click="filterContracts(fournisseur.nom, 'fournisseur')">
          {{ fournisseur.nom }}
        </a>
      </li>
    </ul>
  </div>

              

                <div class="card-body">
                  <h5 class="card-title">Contracts And Structures Table</h5>

                  <vue-good-table
                    :columns="columns"
                    :rows="contracts"
                    :pagination-options="{ enabled: true }"
                    :search-options="{ enabled: true }"
                  />

                </div>

              </div>
            </div>
            <<div class="card shadow-sm rounded-3">
              <div class="card-body pb-0">
                <div class="d-flex justify-content-end mb-2">
                  <a class="icon text-secondary" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li>
                      <a class="dropdown-item" @click="type = 'Dissponible'">Available</a>
                    </li>
                    <li>
                      <a class="dropdown-item" @click="type = 'Indissponible'">Unavailable</a>
                    </li>
                  </ul>
                </div>
            
                <h5 class="card-title mb-3">Number of equipment available/unavailable in each contract</h5>
            
                <div class="row g-2 align-items-center mb-3">
                  <div class="col">
                    <v-autocomplete
                      v-model="selectedContract"
                      :items="contracts"
                      item-title="ref"
                      label="Reference"
                      variant="outlined"
                      class="w-100"
                      @update:model-value="() => selectedContract ? ContractEquipmentDisponible(selectedContract) : null"
                    ></v-autocomplete>
                  </div>
                  <div class="col-auto">
                    <a class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center" @click="setAll()">
                      All
                    </a>
                  </div>
                </div>
            
                <div class="chart-container">
                  <canvas id="ContractEquipmentDisponibleChart"> </canvas>
                </div>
              </div>
            </div>
            
            
    </div>
    
        
    <div class="col-lg-6">
      <div class="col-xxl-12 col-md-6">
          <div class="card info-card sales-card">
            
            <div class="card-body">
              <div class="filter">
                <a class="icon" data-bs-toggle="dropdown">
                  <i class="bi bi-three-dots"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>
                      <a class="dropdown-item" @click="filterEquepmentByType('All','indisponible')">All</a>
                    </h6>
                  </li>
                  <li v-for="(type, index) in uniqueTypes" :key="index">
                    <a class="dropdown-item" @click="filterEquepmentByType(type,'indisponible')">
                      {{ type }}
                    </a>
                  </li>
                </ul>
              </div>
              <h5 class="card-title">Equipement <span>| Unavailable</span></h5>
              <div class="d-flex align-items-center">
                <div
                  class="card-icon rounded-circle d-flex align-items-center justify-content-center"
                >
                  <i class=" ri-computer-line"></i>
                </div>
                <div class="ps-3">
                  <h6>{{indisponibleCount}}</h6>

                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="card">
        

        <div class="card-body pb-0">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="card-title mb-0">Types of Equipment in Structure</h5>
            <a class="btn btn-primary" @click="StructureEuipmentTypeChart('All')">All</a>
          </div>
          <v-autocomplete
            v-model="selectedStructure"
            :items="structures"
            item-title="nom"
            label="Structure"
            variant="outlined"
            return-object
            class="mb-4"
            @update:model-value="() => selectedStructure ? StructureEuipmentTypeChart(selectedStructure.nom) : null"
            ></v-autocomplete>

          

        </div>

        <div class="chart-container">
          <canvas  id="StructureEuipmentType"> </canvas>
        </div>
        
        </div>
                  <div class="card recent-sales overflow-auto">

        <div class="card-body">
                  <h5 class="card-title">Contracts And Euipments Table</h5>

                  <vue-good-table
                    :columns="ContractEquipment"
                    :rows="equipments"
                    :pagination-options="{ enabled: true }"
                    :search-options="{ enabled: true }"
                  />

          </div>
        </div>

      <div class="card">
        

            <div class="card-body pb-0">
              <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="card-title">Number of Contracts by Structure </h5>
                <a class="btn btn-primary" @click="ContractPieChart('all')">All</a>

              </div>

              <v-autocomplete
                v-model="selectedType"
                :items="types"
                item-title="Type"
                label="Select a Type"
                variant="outlined"
                return-object
                class="mb-4"
                @update:model-value="() => selectedType ? ContractPieChart(selectedType) : null"
              ></v-autocomplete>
              <div class="chart-container">
                <canvas  id="EquipementPieChart"> </canvas>
              </div>

            </div>
            
          </div>

         

      
        

    </div>

  </div>
        
  <div class="card recent-sales overflow-auto">

<div class="card-body">
          <h5 class="card-title">Equipments Table</h5>

          <vue-good-table
            :columns="columnsEquipmentEmployer"
            :rows="equipments"
            :pagination-options="{ enabled: true }"
            :search-options="{ enabled: true }"
          />

  </div>

</div>
<div v-if="name === 'admin'" class="card recent-sales overflow-auto">
  <div class="card-body">
          <h5 class="card-title">Activities Table</h5>

          <vue-good-table
            :columns="columnsactivities"
            :rows="activitys"
            :pagination-options="{ enabled: true }"
            :search-options="{ enabled: true }"
          />

  </div>
</div>





</template>

    <script>
    import Chart from "chart.js/auto";
    import CryptoJS from 'crypto-js';

    export default {
      data() {
        return {
          selectedType: null,
          types:'',
          type: 'Dissponible',
        selectedContract: null,
        selectedStructure: {
          nom: '',
        },
        activitys: [],

        columnsactivities: [
        { label: 'Description', field: 'description' },
        { label: 'Subject', field: 'subject' },
        { label: 'At', field: 'time' },
        { label: 'By', field: 'user' },

      ], 
          columnsEquipmentEmployer: [
        { label: 'serial number', field: 'num_serie' },
        { label: 'Type', field: 'Type' },
        { label: 'amortization date', field: 'date_amortissement' },
        { label: 'State', field: 'etat' },
        { label: 'Condition', field: 'status' },
        { label: 'Employer Code', field: 'employer.code' },
        { label: 'Employer First Name', field: 'employer.prenom' },
        { label: 'Employer Last Name', field: 'employer.nom' },
        { label: 'Provider', field: 'employer.fonc' },
        { label: 'Structure', field: 'structure' },

      ], // Define table columns

          columns: [
        { label: 'Contract Reference', field: 'ref' },
        { label: 'Provider', field: 'fournisseur' },
        { label: 'Str Contract', field: 'structure' },
        { label: 'Guarantee', field: 'garantie' },
        { label: 'Contract Type', field: 'Type_contract' },
        { label: 'Date of Acquisition', field: 'date_acquisition' },
      ], // Define table columns
      ContractEquipment: [
        { label: 'Contract Reference', field: 'contractRef' },
        { label: 'Provider', field: 'fournisseur' },
        { label: 'Equipment', field: 'num_serie' },
        { label: 'amortization date', field: 'date_amortissement' },


      
      ], // Define table columns
          equipments: [],
          DisponibleEquipments: [], // Filtered available equipment
          IndisponibleEquipments: [], // Filtered available equipment
          disponibleCount: 0, // Count of available (disponible) equipment
          indisponibleCount: 0, // Count of anavailable (indisponible) equipment
          uniqueTypes: [], // List of unique equipment types
          DisponibleEquipmentsType: [], // Array to store filtered equipment by type
          typeCountsL: [],
          contracts: [], //Array to store contracts
          structures: [], //Array to store structures
          fournisseurs: [], //Array to store fournisseurs
          contractsByType: [], // Array to store filtered equipment by contracts
          typeCountsStructure: [],

          name:'',

        };
      },
      mounted() {
        
        this.getFournisseur();
        this.getContract();
        this.getEquipment();
        this.getStructure();
        this.getActivity();


        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        let encryptedData = urlParams.get('data');
        

        if (encryptedData) {
            try {
                // Decrypt the data
                const secretKey = "abdou";
                const bytes = CryptoJS.AES.decrypt(encryptedData, secretKey);
                const decryptedData = JSON.parse(bytes.toString(CryptoJS.enc.Utf8));

                // Access the decrypted values
                console.log('Decrypted User Data:', decryptedData);
                const {  username } = decryptedData;
                

                this.name = username;
                console.log(this.name);
                


               


            } catch (error) {
                console.error('Failed to decrypt data:', error);
            }
        }

       
      },  
      watch: {
        type(){
          this.ContractEquipmentDisponible(this.selectedContract);
        },
        uniqueTypes(newUniqueTypes) {

          if (newUniqueTypes.length > 0) {

            
            this.renderChart('all');  // Re-render the chart when uniqueTypes is updated
          }
        },
        structures(newStructures) {
          if (newStructures.length > 0) {
            this.ContractPieChart('all'); // Call your chart function here
            this.EquipmentEmployerPieChart('All');
            this.StructureEuipmentTypeChart('All');
          }
        },
        disponibleCount(newContracts){
          this.ContractEquipmentDisponible('all');
        }
        
      },
      methods:{


        setAll(){
          this.selectedContract = 'all';
          this.ContractEquipmentDisponible('all');
        },

        getActivity(){

          axios
            .get("/api/activity/getActivity")
            .then((response) => {
              this.activitys = response.data;
              console.log('activity',response);
              
              
              
            })
            .catch((error) => {
              console.error("Error fetching data:", error);
            });
        },
        getStructure(){

          axios
            .get("/api/structure/getStructure")
            .then((response) => {
              this.structures = response.data;
              console.log('structures',this.structures);
              
              
              
            })
            .catch((error) => {
              console.error("Error fetching data:", error);
            });

        },
        getFournisseur() {
    // Retrieve the token from localStorage or sessionStorage
    const token = localStorage.getItem('auth_token'); // Adjust this based on where you store the token


// Log the token to the console
console.log('Token contract :', token)
          axios
            .get("/api/provider/getProvider", {
            headers: {
                'Authorization': `Bearer ${token}` // Use template literals correctly
            },
            withCredentials: true
        })
        .then((response) => {
            this.fournisseurs = response.data; // Update based on actual response structure
            console.log('Provider data:', response);
        })
        .catch((error) => {
            if (error.response) {
                console.error("Server responded with an error:", error.response.data);
            } else if (error.request) {
                console.error("No response received:", error.request);
            } else {
                console.error("Error setting up request:", error.message);
            }
        });
},


        getContract(){

          // Retrieve the token from localStorage or sessionStorage
    const token = localStorage.getItem('auth_token'); // Adjust this based on where you store the token

// Log the token to the console
console.log('Token contract :', token)
          axios
            .get("/api/contracts/getContracts", {
            headers: {
                'Authorization': `Bearer ${token}` // Use template literals correctly
            },
            withCredentials: true
        })
            .then((response) => {
              this.contracts = response.data;
              this.allContracts = response.data;
              console.log('contract',response);
              
                         
              
            })
            .catch((error) => {
              console.error("Error fetching data:", error.data);
            });

        },
       
        getEquipment() {       
            axios
                .get("/api/equipment/getEquipment")
                .then((response) => {
                    // Filter only available equipment
                    this.equipments = response.data;

                    console.log(this.equipments);
                     this.types = [...new Set(this.equipments.map(equipment => equipment.Type))];

                    
                    // Get unique equipment types
                    this.uniqueTypes = [...new Set(this.equipments.map(item => item.Type))];

                    // Calculate the count of equipment for each type
                    this.typeCounts = this.uniqueTypes.map(type => {
                      // Count how many equipment items are of this type
                      const count = this.equipments.filter(item => item.Type === type).length;
                      return { type, count };  // Return an object with the type and count
                    });

                    this.typeCountsStructure = this.uniqueTypes.map(type => {
                      // Count how many equipment items are of this type and have a status of 'indisponible'
                      const count = this.equipments.filter(item => item.Type === type && item.status === 'indisponible').length;
                      return { type, count }; // Return an object with the type and count
                    });

                    
                    // Filter equipment where status is "disponible"
                    this.DisponibleEquipments = this.equipments.filter(item => item.status === 'disponible');
                    
                    // Count how many have the status "disponible"
                    this.disponibleCount = this.DisponibleEquipments.length;
                    


                    // Filter equipment where status is "indisponible"
                    this.IndisponibleEquipments = this.equipments.filter(item => item.status === 'indisponible');
                    console.log('indosspinble', this.IndisponibleEquipments);
                    
                    
                    // Count how many have the status "indisponible"
                    this.indisponibleCount = this.IndisponibleEquipments.length;



                    
                })
                .catch((error) => {
                  alert(error);
                    console.error("Error fetching data:", error);
                });
        },
        filterContracts(value, type = 'All') {
  // Declare structure and fournisseur with default values
  
  
  let structure = this.structure || 'All';
  let fournisseur = this.fournisseur || 'All';
          
  // Update structure or fournisseur based on the type
  if (type === 'structure') {
    structure = value;
  } else if (type === 'fournisseur') {
    fournisseur = value;
  }

  this.contracts = this.allContracts.filter(item => {
    // Apply filter for structure if it's not 'All'
    const structureMatch = structure === 'All' || item.structure   === structure;

    // Apply filter for fournisseur if it's not 'All'
    const fournisseurMatch = fournisseur === 'All' || item.fournisseur === fournisseur;

    // Only include items that match both conditions
    return structureMatch && fournisseurMatch;
  });

},

        filterEquepmentByType(type, etat) {
          
          
          if(etat === 'disponible'){
            if (type === 'All') {
            // If "All" is selected, show all available equipment
            this.DisponibleEquipmentsType = this.DisponibleEquipments;
            
            } else {
              // Otherwise, filter by the selected type
              this.DisponibleEquipmentsType = this.DisponibleEquipments.filter(item => item.Type === type);

            }
                  // Update the count of "disponible" equipment based on the filtered type
          this.disponibleCount = this.DisponibleEquipmentsType.length;
          }else{
            if (type === 'All') {
            // If "All" is selected, show all available equipment
            this.DisponibleEquipmentsType = this.IndisponibleEquipments;
            
            } else {
              // Otherwise, filter by the selected type
              this.DisponibleEquipmentsType = this.IndisponibleEquipments.filter(item => item.Type === type);

            }
                  // Update the count of "disponible" equipment based on the filtered type
            this.indisponibleCount = this.DisponibleEquipmentsType.length;
          }
          

        },
        renderChart(type) {
      const canvas = document.getElementById("myChart");
      if (canvas && this.uniqueTypes.length > 0) {
        const ctx = canvas.getContext("2d");

        if (this.chartInstance) {
          // Destroy the previous chart instance to avoid multiple charts on the canvas
          this.chartInstance.destroy();
        }

        let labels, data;
        

        if (type === 'all') {
          labels = this.typeCounts.map(item => item.type); // Get types as labels
          data = this.typeCounts.map(item => item.count); // Get counts as data
        } else {
          labels = this.typeCounts
            .filter(item => item.type === type) // Filter items by type
            .map(item => item.type); // Get filtered types as labels
          data = this.typeCounts
            .filter(item => item.type === type) // Filter items by type
            .map(item => item.count); // Get filtered counts as data
        }
        this.chartInstance = new Chart(ctx, {
          type: "bar",
          data: {
            labels: labels,
            datasets: [
              {
                label: "Nombre Equipement par Type",
                data: data,
                backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#a3db48", "#47bab2", "#7777d4", "#0a0559"], // Pie slice colors (you can add more if needed)

                
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: "top",
                display: false, // Hide the legend

              },
            },
            scales: {
              y: {
                beginAtZero: true,
              },
            },
          },
        });
      }
    },


    ContractPieChart(type) {
  // Destroy existing chart instance (if any) to avoid duplicates
  if (this.pieChartInstance) {
    this.pieChartInstance.destroy();
  }
  let data;
  let labels;

  if(type === 'all'){
    labels = [...new Set(this.equipments.map(equipment => equipment.Type))];
    console.log('labels', labels);

    // Calculate contract count per structure
     data = labels.map(type => {
      return this.equipments.reduce((acc, item) => item.Type === type ? acc + 1 : acc, 0);
    });
  }else{
    console.log('hrrr');
    
    labels = [type];
    console.log('labels', labels);

    data = labels.map(type => {
      return this.equipments.reduce((acc, item) => item.Type === type ? acc + 1 : acc, 0);
    });
  }

console.log('data', data);


  // Create the chart
  const ctx = document.getElementById("EquipementPieChart").getContext("2d");
  this.pieChartInstance = new Chart(ctx, {
    type: "pie",
    data: {
      labels: labels, // Labels for the pie chart
      datasets: [
        {
          label: "Nombre of equipment type being used", // Label for the dataset
          data: data, // The contract counts for each structure
          backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#a3db48", "#47bab2", "#7777d4", "#0a0559"], // Pie slice colors (you can add more if needed)
          hoverOffset: 4, // Add a hover effect for better UX
        },
      ],
    },
    options: {
      responsive: true, // Make the chart responsive
      plugins: {
        legend: {
          display: true, // Ensure legend is displayed
          position: "top", // Position of the legend (can be 'top', 'bottom', 'left', 'right')
          labels: {
            font: {
              size: 14, // Font size for legend labels
              family: "Arial", // Font family for legend labels
            },
            color: "#333", // Color of legend labels
          },
        },
      },
    },
  });
},

EquipmentEmployerPieChart(type) {
  // Destroy existing chart instance (if any) to avoid duplicates
  if (this.EquipementEmployerChart) {
    this.EquipementEmployerChart.destroy();
  }

  // Extract labels from the structures
  
let data ;
let labels ; 
  if(type ==='All'){
     labels = this.structures.map(structure => structure.nom);

    // Calculate contract count per structure
     data = this.structures.map(structure => {
    const count = this.IndisponibleEquipments.reduce((acc, item) => {
      return item.employer.id_structure === structure.id ? acc + 1 : acc;
    }, 0);
    return count; // Return the count for this structure
  });
  }else{
    labels = this.structures.filter(item => item.nom === type).map(structure => structure.nom);
    
    data = this.structures.filter(item => item.nom === type).map(structure => {
  const count = this.IndisponibleEquipments.reduce((acc, item) => {
    // Ensure item.employer exists before accessing its properties
    if (item.employer && item.employer.id_structure === structure.id) {
      return acc + 1;
    }
    return acc; // Skip adding if employer is null or doesn't match
  }, 0);
  return count; // Return the count for this structure
});
  }
  
  console.log('data',data);
  

  // Create the chart
  const ctx = document.getElementById("EquipementEmployerChart").getContext("2d");
  this.EquipementEmployerChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels, // Labels for the pie chart
      datasets: [
        {
          label: "Nombre de contrat par structure", // Label for the dataset
          data: data, // The contract counts for each structure
          backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#a3db48", "#47bab2", "#7777d4", "#0a0559"], // Pie slice colors (you can add more if needed)
          hoverOffset: 4, // Add a hover effect for better UX
        },
      ],
    },
    options: {
      responsive: true, // Make the chart responsive
      plugins: {
              legend: {
                position: "top",
                display: false, // Hide the legend

              },
            },
      
    },
  });
},
StructureEuipmentTypeChart(structure) {
  console.log(structure);

  // Destroy existing chart instance (if any) to avoid duplicates
  if (this.StructureEuipmentType instanceof Chart) {
    this.StructureEuipmentType.destroy();
  }

  // Extract unique equipment types (labels for the chart)
  let labels = [...new Set(this.IndisponibleEquipments.map(item => item.Type))];
  console.log('labels', labels);

  let data;
  if(structure === 'All'){
    console.log('type', this.typeCountsStructure);
    
    data = this.typeCountsStructure.map(item => item.count);
  }else{
     data = labels.map((label) => {
    // Get the count of each equipment type for the given structure
    return this.structures
      .filter(item => item.nom === structure)
      .map((structureItem) => {
        const equipmentCountByType = this.IndisponibleEquipments.reduce((acc, item) => {
          if (item.employer.id_structure === structureItem.id) {
            const equipmentType = item.Type;
            if (equipmentType === label) {
              acc++;
            }
          }
          return acc;
        }, 0); // Start counting from 0 for each type
        return equipmentCountByType;
      })
      .reduce((total, count) => total + count, 0); // Sum the counts for this structure
  });
  }

  // Initialize the data array to hold the counts for each equipment type
  
  console.log('data here', data);

  // Create the chart
  const ctx = document.getElementById("StructureEuipmentType").getContext("2d");

  this.StructureEuipmentType = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: labels, // Labels for the pie chart (equipment types)
      datasets: [
        {
          label: "Nombre de contrat par structure", // Label for the dataset
          data: data, // The contract counts for each equipment type
          backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#a3db48", "#47bab2", "#7777d4", "#0a0559"], // Pie slice colors (you can add more if needed)
          hoverOffset: 4, // Add a hover effect for better UX
        },
      ],
    },
    options: {
      responsive: true, // Make the chart responsive
      plugins: {
        legend: {
          position: "top",
        },
      },
    },
  });
},
ContractEquipmentDisponible(contract) {
  // Destroy existing chart instance (if any) to avoid duplicates
  if (this.ContractEquipmentDisponibleInstance) {
    this.ContractEquipmentDisponibleInstance.destroy();
  }

  let type = this.type;
  console.log('type', type);
  console.log('contract', contract);
  
  
  // Extract labels from the structures

  let labels;

if (contract === 'all') {
  labels = this.contracts.map(contract => contract.ref);
  console.log('label ', labels);
} else {
  labels = contract;
  console.log('label ', labels);
}

let data = 0;
if (type === 'Indissponible') {
  data = this.contracts.map(contractItem => {
    // Only count equipment for the selected contract
    if (contract === 'all' || contractItem.ref === contract) {
      const count = this.IndisponibleEquipments.reduce((acc, item) => {
        return item.contract.id_contract === contractItem.id ? acc + 1 : acc;
      }, 0);
      return count;
    }
    return 0;
  });
} else {
  data = this.contracts.map(contractItem => {
    // Only count equipment for the selected contract
    if (contract === 'all' || contractItem.ref === contract) {
      const count = this.DisponibleEquipments.reduce((acc, item) => {
        return item.contract.id_contract === contractItem.id ? acc + 1 : acc;
      }, 0);
      return count;
    }
    return 0;
  });
}

  
  console.log('dataaa',data);
  

  // Create the chart
  const ctx = document.getElementById("ContractEquipmentDisponibleChart").getContext("2d");
  this.ContractEquipmentDisponibleInstance = new Chart(ctx, {
    type: "bar",
    data: {
      labels: labels, // Labels for the pie chart
      datasets: [
        {
          label: "Nombre des equipement " + type +  " par contrat", // Label for the dataset
          data: data, // The contract counts for each structure
          backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#a3db48", "#47bab2", "#7777d4", "#0a0559"], // Pie slice colors (you can add more if needed)
          hoverOffset: 4, // Add a hover effect for better UX
        },
      ],
    },
    options: {
      responsive: true, // Make the chart responsive
      plugins: {
        legend: {
          display: true, // Ensure legend is displayed
          position: "top", // Position of the legend (can be 'top', 'bottom', 'left', 'right')
          labels: {
            font: {
              size: 14, // Font size for legend labels
              family: "Arial", // Font family for legend labels
            },
            color: "#333", // Color of legend labels
          },
        },
      },
    },
  });
},




  
      },
    }
      
</script>

<style scoped>
.chart-container {
      width: 100%;
      max-width: 600px; /* Set a max-width */
      height: 400px; /* Set a fixed height */
      margin: 0 auto; /* Center the container */
    }
    #StructureEuipmentType {
      width: 100%; /* Make the canvas fill the container */
      height: 100%;
    }
    #ContractEquipmentDisponibleChart{
      width: 100%; /* Make the canvas fill the container */
      height: 100%;
    }
</style>

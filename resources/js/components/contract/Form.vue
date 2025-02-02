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
                      <option  >jfkjoih</option>
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
           <table class="table datatable" ref="datatable">
            <thead>
              <tr>
                <th>Num</th>
                <th>Contract Reference</th>
                <th>Provider</th>
                <th>Str Contract</th>
                <th>Guarantee</th>
                <th>Type Contract</th>
                <th>Acquisition Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display message when no contracts are available -->
              <tr v-if="contracts.length === 0">
                <td colspan="7" class="text-center">No contracts available.</td>
              </tr>

              <!-- Loop through contracts -->
              <tr v-for="(contract, index) in contracts" :key="contract.id">
                <!-- Editable Row -->
                <template v-if="editRow === contract.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <input
                      type="text"
                      v-model="editableContract.ref"
                      class="form-control"
                      placeholder="Contract Reference"
                    />
                  </td>
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="editableContract.fournisseur" >
                      <option value="" disabled>Select a Provider</option>
                      <option v-for="fournisseur in fournisseurs" :key="fournisseur.id" :value="fournisseur.nom" >
                        {{ fournisseur.nom }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="editableContract.structure" >
                      <option value="" disabled>Select a Structure</option>
                      <option v-for="structure in structures" :key="structure.id" :value="structure.nom" >
                        {{ structure.nom }}
                      </option>
                    </select>
                  </td>
                  <td>
                    <input
                      type="date"
                      v-model="editableContract.garantie"
                      class="form-control"
                      placeholder="Guarantee"
                    />
                  </td>
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="editableContract.Type_contract" >
                      <option value="" disabled>Select a Type</option>
                      <option  >jfkjoih</option>
                      <option  >kkkk</option>
                    </select>
                  </td>
                  <td>
                    <input
                      type="date"
                      v-model="editableContract.date_acquisition"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <button
                      @click="confirmEdit(contract.id, index)"
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
                  <td>{{ contract.ref }}</td>
                  <td>{{ contract.fournisseur }}</td>
                  <td>{{ contract.structure }}</td>
                  <td>{{ contract.garantie }}</td>
                  <td>{{ contract.Type_contract }}</td>
                  <td>{{ contract.date_acquisition }}</td>
                  <td>
                    <button
                      @click="enableEdit(contract)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deleteContract(contract.id, index)"
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
  methods: {
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

            const insertedData = response.data;

            const tableRef = $(this.$refs.datatable).DataTable();
            tableRef.row.add([
                tableRef.rows().count() + 1, // Auto-increment the "Num" column
                this.form.ref,
                this.form.fournisseur,
                this.form.structure,
                this.form.garantie,
                this.form.Type_contract,
                this.form.date_acquisition,
                `
                    <button
                        @click="enableEdit(contract)"
                        class="btn btn-primary btn-sm"
                      >
                        Edit
                      </button>
                      <button
                        @click="deleteContract(contract.id, index)"
                        class="btn btn-danger btn-sm"
                      >
                        Delete
                      </button>
                ` // Actions column
            ]).draw();

            this.ref = '';
            this.fournisseur = '';
            this.strContract = '';
        })
        .catch((error) => {
          alert("Error submitting form");
          console.log(error.data);
        });
    },
    enableEdit(contract) {
      if (contract && contract.id) {
      this.editRow = contract.id;

      this.editableContract = { ...contract }; // Store a copy of the contract data
  } else {
    console.log('No valid contract data found!');
  }
    },
    confirmEdit(id, index) {
        const updatedContract = this.editableContract;
        console.log('Updated Contract Before Sending:', updatedContract);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/contract/${id}`, updatedContract)
            .then((response) => {
              console.log(response);
              
            alert("Contract updated successfully");
            this.contracts[index] = { ...updatedContract }; // Update contract in the contracts array
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating contract");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editableContract = {}; // Clear the temporary storage
    },
    deleteContract(id, index) {
      if (confirm("Are you sure you want to delete this contract?")) {
        axios
          .delete(`/api/contract/${id}`)
          .then(() => {
            alert("Contract deleted successfully");
            this.contracts.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting contract");
          });
      }
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

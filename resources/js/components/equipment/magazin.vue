<template>
  
    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">


        <div class="card-body">
          <h5 class="card-title">Add a new equipment </h5>
          <form class="row g-3" @submit.prevent="submitForm">
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Num Serie</label>
              <input type="text" v-model="form.num_serie" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Contract</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.contract" >
                    <option value="" disabled>Select a Contract</option>
                    <option v-for="contract in contracts" :key="contract.id" :value="contract.ref" >
                        {{ contract.ref }}
                    </option>
                  </select>
            </div>
            <div class="col-12">
              <label for="inputEmail4" class="form-label">Type</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.Type" >
                    <option value="" disabled>Select a Type</option>
                    <option  >jfkjoih</option>
                    <option  >PC</option>
                  </select>
            </div>
            <div class="col-12">
              <label for="inputPassword4" class="form-label">Marque</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.marque" >
                    <option value="" disabled>Select a Marque</option>
                    <option  >jfkjoih</option>
                  </select>
            </div>
            
            <div class="col-12">
              <label for="inputPassword4" class="form-label">Etat</label>
                  <select class="form-select" aria-label="Default select example" v-model="form.etat" >
                    <option value="" disabled>Select a Etat</option>
                    <option>New</option>
                    <option>Used</option>
                  </select>
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Date D'amortissement</label>
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
            <table class="table datatable" ref="datatable">
              <thead>
                <tr>
                  <th>Num</th>
                  <th>num serie</th>
                  <th>Contract</th>
                  <th>Type</th>
                  <th>marque</th>
                  <th>etat</th>
                  <th>status</th>
                  <th>date_amortissement</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-if="equipments.length === 0">
                  <td colspan="5" class="text-center">No contracts available.</td>
                </tr>
                <tr v-for="(equipment, index) in equipments" :key="equipment.id">
                  <template v-if="editRow === equipment.id">
                    <!-- Editable Row -->
                    <td>{{ index + 1 }}</td>
                    <td>
                      <input
                        type="text"
                        v-model="editableContract.num_serie"
                        class="form-control"
                      />
                    </td>
                    <td>
                      <select class="form-select" aria-label="Default select example" v-model="editableContract.contract" >
                        <option value="" disabled>Select a Contract</option>
                        <option v-for="contract in contracts" :key="contract.id" :value="contract.ref" >
                            {{ contract.ref }}
                        </option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select" aria-label="Default select example" v-model="editableContract.Type" >
                        <option value="" disabled>Select a Type</option>
                        <option  >jfkjoih</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select" aria-label="Default select example" v-model="editableContract.marque" >
                        <option value="" disabled>Select a Marque</option>
                        <option  >jfkjoih</option>
                      </select>
                    </td>
                    <td>
                      <select class="form-select" aria-label="Default select example" v-model="editableContract.etat" >
                        <option value="" disabled>Select a Etat</option>
                        <option>New</option>
                        <option>Used</option>
                      </select>
                    </td>
                    <td>
                      <input
                        type="text"
                        v-model="editableContract.status"
                        class="form-control"
                      />
                    </td>
                    <td>
                      <input
                        type="date"
                        v-model="editableContract.date_amortissement"
                        class="form-control"
                      />
                    </td>
                    <td>
                      <button
                        @click="confirmEdit(equipment.id, index)"
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
                  <template v-else>
                    <!-- Normal Row -->
                    <td>{{ index + 1 }}</td>
                    <td>{{ equipment.num_serie }}</td>
                    <td>{{ equipment.contract.ref }}</td>
                    <td>{{ equipment.Type }}</td>
                    <td>{{ equipment.marque }}</td>
                    <td>{{ equipment.etat }}</td>
                    <td>{{ equipment.status }}</td>
                    <td>{{ equipment.date_amortissement }}</td>
                    
                    <td>
                      <button
                        @click="enableEdit(equipment)"
                        class="btn btn-primary btn-sm"
                      >
                        Edit
                      </button>
                      &nbsp;
                      <button
                        @click="deleteContract(equipment.id, index)"
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
        num_serie: "",
        contract:"",
        Type: "",
        marque: "",
        etat: "",
        date_amortissement: "",
      },
      equipments: [],
      contracts:[],
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
  },
  methods: {
    fetchEquipments() {
      axios
        .get("/equipment/getEquipment")
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
        .post("/equipment", this.form)
        .then(response => {
          
            alert('Equipment inserted successfully');

            const insertedData = response.data;

            const tableRef = $(this.$refs.datatable).DataTable();
            this.form.status = this.form.etat;
            tableRef.row.add([
                tableRef.rows().count() + 1, // Auto-increment the "Num" column
                this.form.num_serie,
                this.form.contract,
                this.form.Type,
                this.form.marque,
                this.form.etat,
                this.form.status,
                this.form.date_amortissement,
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
    confirmEdit(id, index) {
        const updatedEquipment = this.editableContract;
        console.log('Updated Contract Before Sending:', updatedEquipment);
        

        axios
            .put(`/equipment/${id}`, updatedEquipment)
            .then(() => {
            alert("Contract updated successfully");
            this.equipments[index] = { ...updatedEquipment }; 
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
          .delete(`/equipment/${id}`)
          .then((response) => {
            alert("Contract deleted successfully");
            this.equipments.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting contract");
          });
      }
    },
    getContract(){

      axios
        .get("/contracts/getContracts")
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
        .get("/provider/getProvider")
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

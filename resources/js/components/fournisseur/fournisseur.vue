<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">fournisseur Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            <div class="col-12">
              <label for="inputNanme4" class="form-label">Provider</label>
              <input type="text" v-model="form.fournisseur" class="form-control" />
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
          <h5 class="card-title">All Providers</h5>
          <div id="Table">
           <table class="table datatable" ref="datatable">
            <thead>
              <tr>
                <th>Num</th>
                <th>Name</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display message when no fournisseurs are available -->
              <tr v-if="fournisseurs.length === 0">
                <td colspan="7" class="text-center">No fournisseurs available.</td>
              </tr>

              <!-- Loop through fournisseurs -->
              <tr v-for="(fournisseur, index) in fournisseurs" :key="fournisseur.id">
                <!-- Editable Row -->
                <template v-if="editRow === fournisseur.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <input
                      type="text"
                      v-model="editablefournisseur.nom"
                      class="form-control"
                      placeholder="fournisseur Reference"
                    />
                  </td>
                  <td>
                    <button
                      @click="confirmEdit(fournisseur.id, index)"
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
                  <td>{{ fournisseur.nom }}</td>
                  <td>
                    <button
                      @click="enableEdit(fournisseur)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deletefournisseur(fournisseur.id, index)"
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
        fournisseur: "",

      },
      fournisseurs: [],
      structures: [],
      name: '',
      editRow: null, // To track the row being edited
      editablefournisseur: {
        nom: "",
      }, // To temporarily store the editable fournisseur data
    };
  },
  mounted() {
    this.fetchfournisseurs();
    this.getStructure();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  methods: {
    fetchfournisseurs() {
      axios
        .get("/api/provider/getProvider")
        .then((response) => {
          this.fournisseurs = response.data;
          console.log(response.data);
          if(this.fournisseurs){
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
        .post("/api/provider", this.form)
        .then(response => {
          console.log(response.data);
            alert('Fournisseur inserted successfully');

            const insertedData = response.data;

            const tableRef = $(this.$refs.datatable).DataTable();
            tableRef.row.add([
                tableRef.rows().count() + 1, // Auto-increment the "Num" column
                this.form.fournisseur,     
                `
                    <button
                        @click="enableEdit(fournisseur)"
                        class="btn btn-primary btn-sm"
                      >
                        Edit
                      </button>
                      <button
                        @click="deletefournisseur(fournisseur.id, index)"
                        class="btn btn-danger btn-sm"
                      >
                        Delete
                      </button>
                ` // Actions column
            ]).draw();

            this.ref = '';
            this.fournisseur = '';
            this.strfournisseur = '';
        })
        .catch((error) => {
          alert("Error submitting form");
        });
    },
    enableEdit(fournisseur) {
      if (fournisseur && fournisseur.id) {
      this.editRow = fournisseur.id;

      this.editablefournisseur = { ...fournisseur }; // Store a copy of the fournisseur data
  } else {
    console.log('No valid fournisseur data found!');
  }
    },
    confirmEdit(id, index) {
        const updatedfournisseur = this.editablefournisseur;
        console.log('Updated fournisseur Before Sending:', updatedfournisseur);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/provider/${id}`, updatedfournisseur)
            .then((response) => {
              console.log(response);
              
            alert("fournisseur updated successfully");
            this.fournisseurs[index] = { ...updatedfournisseur }; // Update fournisseur in the fournisseurs array
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating fournisseur");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editablefournisseur = {}; // Clear the temporary storage
    },
    deletefournisseur(id, index) {
      if (confirm("Are you sure you want to delete this fournisseur?")) {
        axios
          .delete(`/api/provider/${id}`)
          .then(() => {
            alert("fournisseur deleted successfully");
            this.fournisseurs.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting fournisseur");
          });
      }
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

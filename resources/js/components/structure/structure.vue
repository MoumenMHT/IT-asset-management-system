<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Structure Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            <div class="col-12">
              <label for="inputNanme4" class="form-label">structure</label>
              <input type="text" v-model="form.structure" class="form-control" />
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
          <h5 class="card-title">All structures</h5>
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
              <!-- Display message when no structures are available -->
              <tr v-if="structures.length === 0">
                <td colspan="7" class="text-center">No structures available.</td>
              </tr>

              <!-- Loop through structures -->
              <tr v-for="(structure, index) in structures" :key="structure.id">
                <!-- Editable Row -->
                <template v-if="editRow === structure.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <input
                      type="text"
                      v-model="editablestructure.nom"
                      class="form-control"
                      placeholder="structure Reference"
                    />
                  </td>
                  <td>
                    <button
                      @click="confirmEdit(structure.id, index)"
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
                  <td>{{ structure.nom }}</td>
                  <td>
                    <button
                      @click="enableEdit(structure)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deletestructure(structure.id, index)"
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
        structure: "",

      },
      structures: [],
      structures: [],
      name: '',
      editRow: null, // To track the row being edited
      editablestructure: {
        nom: "",
      }, // To temporarily store the editable structure data
    };
  },
  mounted() {
    this.fetchstructures();
    this.getStructure();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
  },
  methods: {
    fetchstructures() {
      axios
        .get("/api/structure/getStructure")
        .then((response) => {
          this.structures = response.data;
          console.log(response.data);
          if(this.structures){
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
        .post("/api/structure", this.form)
        .then(response => {
          console.log(response.data);
            alert('structure inserted successfully');

            const insertedData = response.data;

            const tableRef = $(this.$refs.datatable).DataTable();
            tableRef.row.add([
                tableRef.rows().count() + 1, // Auto-increment the "Num" column
                this.form.structure,     
                `
                    <button
                        @click="enableEdit(structure)"
                        class="btn btn-primary btn-sm"
                      >
                        Edit
                      </button>
                      <button
                        @click="deletestructure(structure.id, index)"
                        class="btn btn-danger btn-sm"
                      >
                        Delete
                      </button>
                ` // Actions column
            ]).draw();

            this.ref = '';
            this.structure = '';
            this.strstructure = '';
        })
        .catch((error) => {
          alert("Error submitting form");
        });
    },
    enableEdit(structure) {
      if (structure && structure.id) {
      this.editRow = structure.id;

      this.editablestructure = { ...structure }; // Store a copy of the structure data
  } else {
    console.log('No valid structure data found!');
  }
    },
    confirmEdit(id, index) {
        const updatedstructure = this.editablestructure;
        console.log('Updated structure Before Sending:', updatedstructure);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/structure/${id}`, updatedstructure)
            .then((response) => {
              console.log(response);
              
            alert("structure updated successfully");
            this.structures[index] = { ...updatedstructure }; // Update structure in the structures array
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating structure");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editablestructure = {}; // Clear the temporary storage
    },
    deletestructure(id, index) {
      if (confirm("Are you sure you want to delete this structure?")) {
        axios
          .delete(`/api/structure/${id}`)
          .then(() => {
            alert("structure deleted successfully");
            this.structures.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting structure");
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

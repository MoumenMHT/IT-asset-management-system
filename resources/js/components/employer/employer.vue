<template>

    <div class="col-lg-12">
      <!-- Form Section -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Employer Form</h5>
          <form class="row g-3" @submit.prevent="submitForm">

            <div class="col-12">
              <label for="inputNanme4" class="form-label">Nom Employer</label>
              <input type="text" v-model="form.nom" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Prenom Employer</label>
              <input type="text" v-model="form.prenom" class="form-control" />
            </div>
            <div class="col-12">
              <label for="inputNanme4" class="form-label">Fonctionnement </label>
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
           <table class="table datatable" ref="datatable">
            <thead>
              <tr>
                <th>Num</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Fonctionnement</th>
                <th>Code</th>
                <th>Structure</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <!-- Display message when no employers are available -->
              <tr v-if="employers.length === 0">
                <td colspan="7" class="text-center">No employers available.</td>
              </tr>

              <!-- Loop through employers -->
              <tr v-for="(employer, index) in employers" :key="employer.id">
                <!-- Editable Row -->
                <template v-if="editRow === employer.id">
                  <td>{{ index + 1 }}</td>
                  <td>
                    <input
                      type="text"
                      v-model="editableemployer.nom"
                      class="form-control"
                      placeholder="employer Reference"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="editableemployer.prenom"
                      class="form-control"
                      placeholder="employer Reference"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="editableemployer.fonc"
                      class="form-control"
                      placeholder="employer Reference"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      v-model="editableemployer.code"
                      class="form-control"
                      placeholder="employer Reference"
                    />
                  </td>
                  
                  <td>
                    <select class="form-select" aria-label="Default select example" v-model="editableemployer.structure" >
                      <option value="" disabled>Select a Structure</option>
                      <option v-for="structure in structures" :key="structure.id" :value="structure.nom">
                        {{ structure.nom }}
                      </option>
                    </select>
                  </td>
                  

                  <td>
                    <button
                      @click="confirmEdit(employer.id, index)"
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
                  <td>{{ employer.nom }}</td>
                  <td>{{ employer.prenom }}</td>
                  <td>{{ employer.fonc }}</td>
                  <td>{{ employer.code }}</td>
                  <td>{{ employer.structure }}</td>
                  <td>
                    <button
                      @click="enableEdit(employer)"
                      class="btn btn-primary btn-sm"
                    >
                      Edit
                    </button>
                    &nbsp;
                    <button
                      @click="deleteemployer(employer.id, index)"
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
  methods: {
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

            const insertedData = response.data;

            const tableRef = $(this.$refs.datatable).DataTable();
            tableRef.row.add([
                tableRef.rows().count() + 1, // Auto-increment the "Num" column
                this.form.nom,
                this.form.prenom,
                this.form.fonc,
                this.form.code,
                this.form.structure,
                `
                    <button
                        @click="enableEdit(employer)"
                        class="btn btn-primary btn-sm"
                      >
                        Edit
                      </button>
                      <button
                        @click="deleteemployer(employer.id, index)"
                        class="btn btn-danger btn-sm"
                      >
                        Delete
                      </button>
                ` // Actions column
            ]).draw();

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
    confirmEdit(id, index) {
        const updatedemployer = this.editableemployer;
        
        console.log('Updated employer Before Sending:', updatedemployer);
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/employe/${id}`, updatedemployer)
            .then((response) => {
              console.log(response);
              
            alert("employer updated successfully");
            
            this.employers[index] = { ...updatedemployer }; // Update employer in the employers array
            
            
            this.editRow = null; // Exit editing mode
            })
            .catch((error) => {
            alert("Error updating employer");
            console.log(error);
        });
    },
    cancelEdit() {
      this.editRow = null;
      this.editableemployer = {}; // Clear the temporary storage
    },
    deleteemployer(id, index) {
      if (confirm("Are you sure you want to delete this employer?")) {
        axios
          .delete(`/api/employe/${id}`)
          .then(() => {
            alert("employer deleted successfully");
            this.employers.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting employer");
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

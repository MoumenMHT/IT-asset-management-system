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
            <v-data-table
              :headers="headers"
              :items="structures"
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
                    
                  >
                    <v-text-field
                      v-model="editedItem.nom"
                      label="Structure Name"
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

      headers:[
      { title: 'Name', key:'nom' },
      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],
    };
  },
      computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit History'
        },
      },
     

  
  mounted() {
    this.fetchstructures();
    this.getStructure();
    // Retrieve the 'name' query parameter from the URL without using Vue Router
        const queryParams = new URLSearchParams(window.location.search);
        this.name = queryParams.get('name'); // Get the 'name' parameter from the URL
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
        this.editedIndex = this.structures.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.structures.indexOf(item)
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
          console.log(response.data.data);
            alert('structure inserted successfully');


            this.structures.unshift(response.data.data);


            this.ref = '';
            this.structure = '';
            this.strstructure = '';
        })
        .catch((error) => {
          alert("Error submitting form");
        });
    },
    
    close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },
    save() {
        const updatedstructure = this.editedItem;
        console.log('Updated structure Before Sending:', updatedstructure);
        
        let id = updatedstructure.id;
        const editedIndex = this.editedIndex;  

        
        
        

        axios
            .put(`/api/structure/${id}`, updatedstructure)
            .then((response) => {
              console.log(response);
              console.log("Edited Index:",editedIndex);

              alert("structure updated successfully");
            
              Object.assign(this.structures[editedIndex], updatedstructure);
            })
            .catch((error) => {
            alert("Error updating structure");
            console.log(error);
        });
        this.close();
    },
    cancelEdit() {
      this.editRow = null;
      this.editablestructure = {}; // Clear the temporary storage
    },
    deleteItemConfirm () {
      const id = this.editedItem.id;
      const index = this.editedIndex;
        axios
          .delete(`/api/structure/${id}`)
          .then(() => {
            alert("structure deleted successfully");
            this.structures.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting structure");
          });
          this.closeDelete();
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

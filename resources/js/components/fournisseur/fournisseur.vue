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
            <v-data-table
            :headers="headers"
            :items="fournisseurs"
            :search="search"  
            :sort-by="[{ key: 'created_at', order: 'desc' }]"
          >
            <template v-slot:top>
              <v-toolbar
                flat
              >
              <v-text-field
                v-model="search"
                label="Search"
                prepend-inner-icon="mdi-magnify"
              >
            </v-text-field> 
              
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
      search: '',
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
      { title: 'Name', key:'nom' },
      { title: 'Created At', key:'created_at' },  
      { title: 'Actions', key: 'actions', sortable: false },

      ],
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
  computed: {
        formTitle () {
          return this.editedIndex === -1 ? 'New History' : 'Edit Provider'
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
        this.editedIndex = this.fournisseurs.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

    editItem (item) {
      console.log('sdasdfaf');
      
        this.editedIndex = this.fournisseurs.indexOf(item)
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

            const insertedData = response.data.data;
            console.log(insertedData);
            this.fournisseurs.unshift(insertedData);

            

            
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
    save() {
      if ( !this.editedItem || !this.editedItem.nom ) {
        console.error('Error: Missing required fields in editedItem', this.editedItem);
        alert('Please fill in all required fields before saving.');
        return;
      }
        const updatedfournisseur = this.editedItem;
        console.log('Updated fournisseur Before Sending:', updatedfournisseur);
        const index = this.editedIndex;
        const id = updatedfournisseur.id;
        console.log(index);
        console.log(id);
        
        

        axios
            .put(`/api/provider/${id}`, updatedfournisseur)
            .then((response) => {
              console.log(response);
              
            alert("fournisseur updated successfully");
            Object.assign(this.fournisseurs[index], updatedfournisseur);
          })
            .catch((error) => {
            alert("Error updating fournisseur");
            console.log(error);
        });
        this.close();
    },
    cancelEdit() {
      this.editRow = null;
      this.editablefournisseur = {}; // Clear the temporary storage
    },
    deleteItemConfirm() {
      
      const id = this.editedItem.id;
      const index = this.editedIndex;

        axios
          .delete(`/api/provider/${id}`)
          .then(() => {
            alert("fournisseur deleted successfully");
            this.fournisseurs.splice(index, 1);
            
          })
          .catch((error) => {
            alert("Error deleting fournisseur");
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

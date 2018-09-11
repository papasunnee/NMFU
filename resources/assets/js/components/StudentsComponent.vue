<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Unit Students</h3>

                <div class="card-tools" v-if="authUserType()">
                    <button class="btn btn-success" @click="newModal">{{ modalLabel}}
                        <i class="fas fa-user-plus fa-fw"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <center v-if="loading">
                    <img src="images/loading.gif"  />
                </center>
                <table class="table table-hover" v-else>
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Registration Date</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="(user , index ) in users" :key="user.id">
                    <td>{{++index}}</td>
                    <td><strong>{{user.name | uppercase}}</strong></td>
                    <td>{{user.email | lowercase}}</td>
                    <td><span class="tag tag-success">{{user.type | capitalize}}</span></td>
                    <td><span class="tag tag-success">{{user.created_at | date}}</span></td>
                    <td>
                        <a href="#" @click.prevent="editModal(user)" title="Quick Edit">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click.prevent="userProfile(user)" title="View">
                            <i class="fas fa-eye teal"></i>
                        </a>
                        /
                        <a href="#" @click.prevent="deleteStudent(user.id)" title="Delete">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">{{editmode ? 'Edit Student' : 'Add New Student'}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off"  @submit.prevent="editmode ? updateUser() : createUser()" @keydown="form.onKeydown($event)">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name" id="name"
                                placeholder="Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.email" type="text" name="email" id="email"
                                placeholder="Email Address" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>
                        <div class="form-group">
                            <textarea v-model="form.bio" type="text" name="bio" id="bio"
                                placeholder="Short bio for user (Optional)" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                            <has-error :form="form" field="bio"></has-error>
                        </div>
                        <div class="form-group">
                            <select v-model="form.type" name="type" id="type"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="">Select User Role</option>
                                <option value="user">User</option>
                                <option value="student">Student</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('password') }"/>
                            <has-error :form="form" field="password"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button  v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
  props: ["auth_user"],
  data() {
    return {
      editmode: false,
      modalLabel: "Add New Student",
      loading: false,
      users: {},
      form: new Form({
        id: "",
        name: "",
        email: "",
        bio: "",
        type: "",
        photo: "",
        password: ""
      })
    };
  },
  methods: {
    fetctStudents() {
      this.loading = true;
      axios.get("api/students").then(({ data, data: { data: userdata } }) => {
        this.users = userdata;
        this.loading = false;
      });
    },
    editModal(student) {
      this.editmode = true;
      this.form.reset();
      this.form.fill(student);
      $("#addNew").modal("show");
    },
    newModal() {
      this.editmode = false;
      this.form.reset();
      $("#addNew").modal("show");
    },
    createUser() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("api/users")
        .then(({ data }) => {
          $("#addNew").modal("hide");
          this.$Progress.finish();
          //this.fetctStudents();
          Fire.$emit("ReloadStudents");
          toast({
            type: "success",
            title: "New User Added Successfully"
          });
        })
        .catch(({ error }) => {
          this.$Progress.fail();
          console.log(error);
        });
    },
    authUserType() {
      return this.auth_user.type == "admin" || this.auth_user.type == "user";
    },
    updateUser() {
      this.$Progress.start();
      this.form
        .put("api/students/" + this.form.id)
        .then(() => {
          //success
          Fire.$emit("ReloadStudents");
          $("#addNew").modal("hide");
          swal("Updated!", "Information has been updated", "success");
          this.$Progress.finish();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    deleteStudent(studentID) {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          //Send request to server for processing
          this.form
            .delete("api/users/" + studentID)
            .then(data => {
              Fire.$emit("ReloadStudents");
              toast({
                type: "success",
                title: "User successfully deleted"
              });
            })
            .catch(error => {
              console.log(error);
              swal({
                type: "error",
                title: "Oops...",
                text: "Something went wrong!"
                //   footer: "<a href>Why do I have this issue?</a>"
              });
            });
        }
      });
    },
    userProfile() {
      console.log("demo");
    }
  },
  created() {
    this.authUserType();
    this.fetctStudents();
    Fire.$on("ReloadStudents", () => {
      this.fetctStudents();
    });
  }
};
</script>

<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Unit Members</h3>

                <div class="card-tools" v-show="authUserType()">
                    <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Add New
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
                    <span v-show="authUserType()">
                        <th>Modify</th>
                    </span>
                  </tr>
                  <tr v-for="(user , index ) in users" :key="user.id">
                    <td>{{++index}}</td>
                    <td><strong>{{user.name | uppercase}}</strong></td>
                    <td>{{user.email | lowercase}}</td>
                    <td><span class="tag tag-success">{{user.type | capitalize}}</span></td>
                    <td><span class="tag tag-success">{{user.created_at | date}}</span></td>
                    <span v-show="authUserType()">
                    <td>
                        
                        <a href="#">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#"  @click.prevent="deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>
                    </span>
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
                    <h5 class="modal-title" id="addNewLabel">Add New</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form autocomplete="off"  @submit.prevent="createUser" @keydown="form.onKeydown($event)">
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
                                <option value="admin">Admin</option>
                                <option value="user">Standard User</option>
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
                        <button type="submit" class="btn btn-primary">Create</button>
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
      loading: false,
      users: {},
      form: new Form({
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
    fetctUsers() {
      this.loading = true;
      axios.get("api/users").then(({ data, data: { data: userdata } }) => {
        this.users = userdata;
        this.loading = false;
        console.log(data.current_page);
      });
    },
    createUser() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("api/users")
        .then(({ data }) => {
          $("#addNew").modal("hide");
          this.$Progress.finish();
          this.fetctUsers();
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
      return this.auth_user.type == "admin";
    },
    deleteUser(userID) {
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
            .delete("api/users/" + userID)
            .then(data => {
              Fire.$emit("ReloadUser");
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
    }
  },
  created() {
    this.fetctUsers();
    Fire.$on("ReloadUser", () => {
      this.fetctUsers();
    });
  }
};
</script>

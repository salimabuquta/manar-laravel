<template>
    <div class="card">
        <div class="card-header bg-primary text-white">Create New User</div>

        <div class="card-body">
            <form @submit="onSubmit">
                <div class="form-group row">
                    <label for="inpu1"
                           class="col-sm-3 col-form-label ">Username </label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="model.username"
                               :class="'form-control ' + (errors.username && errors.username[0] ? 'is-invalid' : '') "
                               id="inpu1"
                               placeholder="Enter username here">
                        <div class="invalid-feedback">
                            <div v-for="item in errors.username">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpu2"
                           class="col-sm-3 col-form-label">Email Address </label>
                    <div class="col-sm-9">
                        <input type="email"
                               v-model="model.email"
                               :class="'form-control ' + (errors.email && errors.email[0] ? 'is-invalid' : '') "
                               id="inpu2"
                               placeholder="Enter email here">
                        <div class="invalid-feedback">
                            <div v-for="item in errors.email">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpu3"
                           class="col-sm-3 col-form-label">Name </label>
                    <div class="col-sm-9">
                        <input type="text"
                               v-model="model.name"
                               :class="'form-control ' + (errors.name && errors.name[0] ? 'is-invalid' : '') "
                               id="inpu3"
                               placeholder="Enter name here">
                        <div class="invalid-feedback">
                            <div v-for="item in errors.name">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpu4"
                           class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password"
                               v-model="model.password"
                               :class="'form-control mb-2 ' + (errors.password && errors.password[0] ? 'is-invalid' : '') "
                               id="inpu4"
                               placeholder="********">
                        <div class="text-muted">Password has to contain a combination of letters and numbers with at
                            least one
                            Capital letter.
                        </div>
                        <div class="invalid-feedback">
                            <div v-for="item in errors.password">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpu6"
                           class="col-sm-3 col-form-label">Age</label>
                    <div class="col-sm-9">
                        <select v-model="model.age" name=""
                                :class="'form-control ' + (errors.age && errors.age[0] ? 'is-invalid' : '') "
                                id="inpu6">
                            <option :value="i" v-for="i in range(10,85)">{{ i}}</option>
                        </select>
                        <div class="invalid-feedback">
                            <div v-for="item in errors.age">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inpu7"
                           class="col-sm-3 col-form-label">Biography </label>
                    <div class="col-sm-9">
                        <textarea name=""
                                  v-model="model.biography"
                                  id="inpu7"
                                  :class="'form-control ' + (errors.biography && errors.biography[0] ? 'is-invalid' : '') "
                                  rows="5"
                                  placeholder="Enter Biography here"></textarea>
                        <div class="invalid-feedback">
                            <div v-for="item in errors.biography">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="file"
                           class="col-sm-3 col-form-label">Personal Image </label>
                    <div class="col-sm-9">
                        <input type="file"
                               id="file"
                               :class="'form-control ' + (errors.image && errors.image[0] ? 'is-invalid' : '') "
                               rows="5"
                               placeholder="Enter Biography here"/>
                        <div class="invalid-feedback">
                            <div v-for="item in errors.image">{{ item}}</div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data: function () {
            return {
                model: {
                    username: "",
                    password: "",
                    email: "",
                    name: "",
                    age: 10,
                    biography: "",
                    image: ""
                },
                errors: []
            }
        },
        methods: {
            range: function (start, end) {
                var foo = [];
                for (var i = start; i <= end; i++) {
                    foo.push(i);
                }
                return foo;
            },
            onSubmit: function (e) {
                e.preventDefault();
                let link = "/test/api/users/save";
                let _this = this;

                var formData = new FormData();
                for (let k in _this.model) {
                    formData.append(k, _this.model[k]);
                }
                var imagefile = document.querySelector('#file');
                formData.append("image", imagefile.files[0]);
                axios.post(link, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(function (response) {
                    for (let k in _this.model) {
                        _this.model[k] = "";
                    }
                    document.getElementById("file").value = ""
                    _this.errors = [];
                    _this.$root.$emit('user_saved', 'user_saved');
                    _this.$root.$emit('show_success_message', 'User saved successfully');
                }).catch(error => {
                    _this.errors = error.response.data.errors;
                })
            }
        }
    }
</script>

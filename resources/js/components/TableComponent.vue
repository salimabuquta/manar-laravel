<template>
    <div>
        <div class="d-flex justify-content-end mb-3">
            <div class="col-md-6">
                <select @change="onChangeSorting" name="" v-model="sort_type" id="" class="form-control">
                    <option value="DESC">newest to oldest</option>
                    <option value="ASC">oldest to newest</option>
                </select>
            </div>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col" width="50%">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Age</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in users" v-if="item.username">
                <th scope="row">{{ item.id}}</th>
                <td width="50%">
                    <div class="d-flex align-items-center">
                        <img v-if="item.image"
                             :src="'public/' + item.image"
                             :class="'img-thumbnail mr-2 ' + (item.is_grey ? 'greyscale' : '')"
                             width="50px"
                             :alt="item.username"/>
                        <input style="width : 150px"
                               spellcheck="false"
                               class="input-hidden"
                               type="text"
                               @change="onChangeUsername(item, $event)"
                               :value="item.username">
                        <i class="fa fa-edit text-primary"></i>
                    </div>
                </td>
                <td>{{ item.email }}</td>
                <td>{{ item.age }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                sort_type: "DESC",
                username: "",
                users: []
            }
        },
        mounted() {
            let _this = this;
            let link = "api/users/all";
            axios.get(link).then(response => {
                _this.users = response.data;
            });
            this.$root.$on('user_saved', (text) => { // here you need to use the arrow function
                axios.get(link).then(response => {
                    _this.users = response.data;
                });
            })
        },
        methods: {
            onChangeSorting: function () {
                let _this = this;
                let link = "api/users/all/?sort_type=" + this.sort_type;
                axios.get(link).then(response => {
                    _this.users = response.data;
                })
            },
            onChangeUsername: function (item, event) {
                let id = item.id;
                var new_username = event.target.value;
                let _this = this;
                let link = "api/users/update";
                axios.post(link, {
                    id: id,
                    username: new_username
                }).then(response => {
                    _this.$root.$emit("show_success_message", "Updated successfully")
                }).catch(error => {
                    if (error.response.data.errors.username && error.response.data.errors.username[0]) {
                        let error_msg = error.response.data.errors.username[0];
                        _this.$root.$emit("show_error_message", error_msg)
                    } else {
                        _this.$root.$emit("show_error_message", "Unexpected error happened")
                    }
                });
            }
        }
    }
</script>

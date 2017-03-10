<template>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-3">
            <img class="img-rounded" src="http://placehold.it/150x150" alt="user--img">
        </div>
        <div class="col-md-3">
            <h4>Full name:</h4>
            <div v-show="edit.name" class="edit--block">                
                <input class="form-control" type="text"
                 id="name"
                 v-on:keyup.enter="updateRecord($event)"
                 v-model="name"
                 v-validate="name" 
                 data-vv-rules="required|name_length" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('name')"></i>
            </div>
            <p class="text-danger" v-if="errors.has('name')">{{ errors.first('name') }}</p>
            <p v-show="!edit.name">{{ name }}
                <i class="fa fa-pencil" aria-hidden="true"
                 @click="editClick('name')"></i>
            </p>
        </div>
        <div class="col-md-3">
            <h4>Email</h4>
            <div v-show="edit.email" class="edit--block" :class="{'has-error': errors.has('email') }">                
                <input class="form-control" type="text"
                 id="email"
                 v-on:keyup.enter="updateRecord($event)"
                 v-model="email"
                 v-validate="email" 
                 data-vv-rules="required|email" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('email')"></i>
            </div>
            <p class="text-danger" v-if="errors.has('email')">{{ errors.first('email') }}</p>
            <p v-show="!edit.email">{{ email }}
                <i class="fa fa-pencil" aria-hidden="true"
                 @click="editClick('email')"></i>
            </p>
        </div>
        <div class="col-md-3">
            <h4>Login</h4>
            <div v-show="edit.login" class="edit--block">                
                <input class="form-control" type="text"
                 id="login"
                 v-on:keyup.enter="updateRecord($event)"
                 v-model="login"
                 v-validate="login" 
                 data-vv-rules="required|login_length" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('login')"></i>
            </div>
            <p class="text-danger" v-if="errors.has('login')">{{ errors.first('login') }}</p>
            <p v-show="!edit.login">{{ login }}
                <i class="fa fa-pencil" aria-hidden="true"
                 @click="editClick('login')"></i>
            </p>
        </div>
    </div>
    <div class="col-md-12">
        <h4 class="text-center">Connected providers:</h4>
        <ul class="list-group">
            <li class="list-group-item" v-for="provider in social">
                {{ provider }}
            </li>
        </ul>
    </div>
</div>
</template>

<script>
Vue.use(VeeValidate);
import { ErrorBag } from 'vee-validate';

    VeeValidate.Validator.extend('name_length', {
        getMessage: field => 'Name must be less than 50 characters.',
        validate: value => value.length < 50
    });

    VeeValidate.Validator.extend('login_length', {
        getMessage: field => 'Login must be more than 3 characters.',
        validate: value => value.length > 3
    });

    export default {
        props: {
            user: Object,
            social: Array
        },
        data() {
            return {
                name: this.user.name,
                email: this.user.email,
                login: this.user.username,
                edit: {
                    name: false,
                    email: false,
                    login: false
                }
            };
        },
        methods: {
            editClick(name) {
                this.errors.clear();
                this.edit[name] = !this.edit[name];
            },
            updateRecord($event) {
                axios.post(`/dashboard/${this.user.id}/update`, {
                        data: $event.target.value,
                        field_name: $event.target.id
                    })
                    .then((response) => {
                        if(response.data.data && response.data.data instanceof Array) {
                            // add error from laravel validator to vee-validate and replace default fild name with user friendly
                            this.errors.add($event.target.id, response.data.data[0].replace('data', $event.target.id));
                        } else if(response.data[$event.target.id]) {
                            this.errors.add($event.target.id, response.data[$event.target.id][0].replace('data', $event.target.id));
                        } else {
                            this.edit[$event.target.id] = !this.edit[$event.target.id];
                        }
                    })
                    .catch((error) => {
                        console.info(error);
                        // TODO: change it to use response.error.message
                        this.errors.add($event.target.id, 'Something wrong with change ', $event.target.id);
                    });
            }
        },
        mounted() {
            // console.log(this.user.id);
        }
    }
</script>

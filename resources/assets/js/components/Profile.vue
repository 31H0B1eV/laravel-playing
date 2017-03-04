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
                 v-on:keyup.enter="editClick('name')"
                 v-model="name" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('name')"></i>
            </div>
            <p v-show="!edit.name">{{ name }}
                <i class="fa fa-pencil" aria-hidden="true"
                 @click="editClick('name')"></i>
            </p>
        </div>
        <div class="col-md-3">
            <h4>Email</h4>
            <div v-show="edit.email" class="edit--block">                
                <input class="form-control" type="text"
                 v-on:keyup.enter="editClick('email')"
                 v-model="email" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('email')"></i>
            </div>
            <p v-show="!edit.email">{{ email }}
                <i class="fa fa-pencil" aria-hidden="true"
                 @click="editClick('email')"></i>
            </p>
        </div>
        <div class="col-md-3">
            <h4>Login</h4>
            <div v-show="edit.login" class="edit--block">                
                <input class="form-control" type="text"
                 v-on:keyup.enter="editClick('login')"
                 v-model="login" >
                <i class="fa fa-times" aria-hidden="true"
                @click="editClick('login')"></i>
            </div>
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
               this.edit[name] = !this.edit[name];
            }
        },
        mounted() {
            // console.log(this.user, this.social);
        }
    }
</script>

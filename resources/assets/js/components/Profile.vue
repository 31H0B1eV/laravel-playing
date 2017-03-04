<template>
    <div class="panel panel-default">
        <div class="panel-heading">Profile Component</div>

        <div class="panel-body">
            <ul>
                <li>{{ user.name }}</li>
                <li>{{ user.email }}</li>
                <h5>Linked providers: </h5>
                <ul>
                    <li v-for="provider in social">
                        {{ provider }}
                    </li>
                </ul>
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
        mounted() {
            // console.log(this.user, this.social);
        }
    }
</script>

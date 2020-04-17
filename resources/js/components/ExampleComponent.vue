<template>
<div class="text-center">
    hehe
    <!-- <button class="btn btn-primary">{{ data }}</button> -->
    <div class="table-responsive">
        <table class="table table-codensed table-striped table-hover">
            <tr>
                <th>S/No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
            <tr v-for="user in users" :key="user.id">
                <td>{{user.id}}</td>
                <td>{{user.username}}</td>
                <td>{{user.role}}</td>
                <td>{{user.status}}</td>
            </tr>
        </table>
    </div>
</div>   
</template>

<script>
    export default {
        data() {
            return{
                users:[]
            }
        },
        created() {
            users=axios.get('http://127.0.0.1:8000/users').then(res=>{
                this.users=res.data
            });
        }
    }
</script>

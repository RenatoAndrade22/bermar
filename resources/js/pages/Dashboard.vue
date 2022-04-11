<template>
    <div>
        <h1>Dashboard</h1>
        <div v-if="user">
            <p>Name: {{ user.name }}</p>
            <p>Email: {{ user.email }}</p>
        </div>
        <p @click="logout">Logout</p>
    </div>
</template>
<script>
export default {
    data(){
        return{
            user: null
        }
    },
    methods:{
        logout(){
            axios.post('/api/logout').then((item) =>{
                this.$router.push({name: "home"})
            })
        },
        getUser(){
            axios.get('api/user').then((item)=>{
                this.user = item.data
            })
        }
    },
    created() {
        this.getUser()
    }
}
</script>

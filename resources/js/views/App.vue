<template>
    <div>
        <flash-message transitionIn="animated swing" class="notification"></flash-message>
        <router-view ></router-view>
    </div>
   
</template>
<script>
    export default {
        data() {
            return {
                user: {},
            }
        },
        mounted() {
            axios.get("/api/user").then((response) => {
                this.user = response.data;
            }).catch(error => {
                this.flash(error.response.data.message, 'error', { timeout: 3000 });
            });
        },
    }
</script>
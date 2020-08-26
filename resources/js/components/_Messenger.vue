<template>
    <div class="messenger">
        <MessageList :messages="messages" />
    </div>
</template>

<script>
    import MessageList from './MessageList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                messages: [],
            };
        },

        mounted() {
            console.log(this.user);
            this.loading = true;

            axios.get('/api/messages').then(response => {
                console.log(response.data);
                this.messages = response.data;
            }).catch(error => {
                this.loading = false;
                this.error = error.response.data.message || error.message;
            });
        },
        components: {
            MessageList,
        }
    };
</script>

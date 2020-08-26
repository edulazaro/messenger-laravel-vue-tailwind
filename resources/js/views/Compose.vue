<template>
    <div class="view-compose flex">
        <UserList :users="users" @selected="writeMessageTo" />
        <Editor :recipient="recipient"  @send="sendMessage"/>
    </div>
</template>

<script>
    import UserList from '../components/UserList';
    import Editor from '../components/Editor';

    export default {
        data() {
            return {
                recipient: null,
                users: [],
            };
        },

        mounted() {
            axios.get("/api/users").then((response) => {
                this.users = response.data;
            }).catch(error => {
                this.flash(error.response.data.message, 'error', { timeout: 3000 });
            });
        },
        methods: {
            sendMessage(subject, content) {
                if (!this.recipient) {
                    this.flash('Invalid recipient.', 'error', { timeout: 3000 });
                    return;
                }
                axios.post('/api/messages', {
                    'to': this.recipient.id,
                    'subject': subject,
                    'content': content,
                }).then((response) => {
                    this.flash('Your message was sent.', 'success', { timeout: 3000 });
                }).catch(error => {
                    this.flash(error.response.data.message, 'error', { timeout: 3000 });
                });
            },
            writeMessageTo(user) {
                this.recipient = user;
            }
        },
        components: { UserList, Editor }
    };
</script>

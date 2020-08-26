<template>
    <div class="message-list">
        <Message :message="message" @readMessage="readMessage" @closeMessage="closeMessage" v-if="message"/>
        <div v-else>
            <table class="w-full flex flex-row flex-no-wrap overflow-hidden sm:shadow-lg" v-if="messages.length">
                <thead class="border-b-0">
                    <tr v-for="message in messages" :key="message.id + '_head'" class="flex flex-col flex-no wrap sm:table-row rounded-l-lg sm:rounded-none mb-2 sm:mb-0">
                        <th class="p-3 text-left">From</th>
                        <th class="p-3 text-left">To</th>
                        <th class="p-3 text-left">Subject</th>
                        <th class="p-3 text-left" width="110px">Actions</th>
                    </tr>
                </thead>
                    <tbody class="flex-1 sm:flex-none">
                        <tr v-for="(message, index) in messages" :key="message.id" @click="viewMessage(index, message)"
                        class="odd:bg-white even:bg-gray-100 hover:bg-gray-200 flex flex-col flex-no wrap sm:table-row mb-2 sm:mb-0 cursor-pointer hover:bg-gray-100"
                        :class="[ message.to === message.user_id && !message.read_at  ?  'font-bold' : '' ]">
                            <td class="border border-l-0 border-r-0 p-3">{{ message.from_user.name }}</td>
                            <td class="border border-l-0 border-r-0 p-3">{{ message.to_user.name }}</td>
                            <td class="border border-l-0 border-r-0 p-3 truncate">{{ message.subject }}</td>
                            <td @click="recoverMessage(index, message)" v-on:click.stop v-if="message.archived_at"
                            class="border border-l-0 border-r-0 p-3 text-red-400 hover:text-red-600 hover:font-medium cursor-pointer">Recover</td>
                            <td @click="archiveMessage(index, message)" v-on:click.stop v-else
                            class="border border-l-0 border-r-0 p-3 text-red-400 hover:text-red-600 hover:font-medium cursor-pointer">Archive</td>
                    </tr>
                </tbody>
            </table>
            <div class="editor w-full p-10 text-gray-400 text-center" v-else> 
                No messages found
            </div>
        </div>
    </div>
</template>

<script>
    import Message from '../components/Message';

    export default {
        props: {
            mailbox:  {
                type: String,
                default: 'inbox'
            }
        },
        components: {
            Message,
        },
        data() {
            return {
                message: null,
                messages: [],
            };
        },
        mounted() {
            this.getMessages();
        },
        methods: {
            getMessages() {
                axios.get('/api/messages?mailbox=' + this.mailbox).then((response) => {
                    this.messages = response.data;
                }).catch(error => {
                    this.flash(error.response.data.message, 'error', { timeout: 3000 });
                });
            },
            viewMessage(index, message) {
                this.message = message;
            },
            closeMessage(){
                this.message = null;
            },
            readMessage(message) {
                this.messages.find(m => m.id === message.id).read_at = message.read_at;
            },
            archiveMessage(index, message) {
                axios.patch('/api/messages/' + message.id, {
                    'archive': true,
                }).then((response) => {
                    this.getMessages();
                }).catch(error => {
                    this.flash(error.response.data.message, 'success', { timeout: 3000 });
                });
            },
            recoverMessage(index, message) {
                axios.patch('/api/messages/' + message.id, {
                    'archive': false,
                }).then((response) => {
                    this.getMessages();
                }).catch(error => {
                    this.flash(error.response.data.message, 'success', { timeout: 3000 });
                });
            }
        }  
    }
</script>

<style>
  @media (min-width: 640px) {
    table {
      display: inline-table !important;
    }

    thead tr:not(:first-child) {
      display: none;
    }
  }

  td:not(:last-child) {
    border-bottom: 0;
  }

  th:not(:last-child) {
    border-bottom: 2px solid rgba(0, 0, 0, .1);
  }
</style>
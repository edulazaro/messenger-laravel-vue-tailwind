<template>
    <div class="message w-full p-10 leading-6 m-auto max-w-6xl ">
        <div class="w-full">
            <label class="block text-gray-700 text-sm font-bold mb-2">From</label>
            <p>{{message.from_user.name}} ({{message.from_user.email}})</p>
        </div>
    
        <div class="w-full my-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">To</label>
            <p>{{message.to_user.name}} ({{message.to_user.email}})</p>
        </div>

        <div class="w-full my-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
            <p>{{message.subject}}</p>
        </div>

        <div class="w-full my-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Content</label>
            <p>{{message.content}} ({{message.content}})</p>
        </div>
        <div class="w-full my-6">
            <button type="submit" v-on:click="closeMessage" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Back
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            message:  {
                type: Object,
                default: null
            }
        },
        data() {
            return {
                close: 0
            };
        },
        created () {
            if (this.message.user_id === this.message.to && !this.message.read_at) {
                axios.patch('/api/messages/' + this.message.id, {
                    'read': true,
                }).then((response) => {
                    this.$emit('readMessage', response.data);
                }).catch(error => {
                    this.flash(error.response.data.message, 'error', { timeout: 3000 });
                });
            }
        },
        methods: {
            closeMessage() {
                this.$emit('closeMessage');
            },
        }  
    }
</script>
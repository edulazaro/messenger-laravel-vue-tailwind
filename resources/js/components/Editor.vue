<template>
    <div class="editor w-full p-10" v-if="recipient"> 
        <form @submit="checkForm"  class="w-full p-6">
            <div class="w-full">
                <label class="block text-gray-700 text-sm font-bold mb-2">Recipient</label>
                <p>{{recipient.name}} ({{recipient.email}})</p>
            </div>

            <div class="w-full my-6">
                <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                <input type="text" name="subject"  v-model="subject" placeholder="Message subject..." class="form-input w-full">
                <p class="text-red-500 italic mt-4" v-if="errorSubject">
                    {{ errorSubject }}
                </p>
            </div>

            <div class="w-full my-6">
                <label for="content" class="text-gray-700 text-sm font-bold mb-2 ">Message</label>
                <textarea name="content" v-model="content" placeholder="Write the message content here..." class="form-input w-full h-48 my-1"></textarea>
                <p class="text-red-500 italic mt-4" v-if="errorContent" >
                    {{ errorContent }}
                </p>
             </div>
            <div class="w-full my-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-gray-100 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Send message
                </button>
            </div>
        </form>
    </div>
    <div class="editor w-full p-10 text-gray-400 text-center" v-else> 
        Please select a recipient
    </div>
</template>

<script>
    export default {
        props: {
             recipient: {
                type: Object,
                default: null,
            },
        },
        data() {
            return {
                errorContent: '',
                errorSubject: '',
                content: '',
                subject: '',
            };
        },
        methods: {
            checkForm(e) {
                const errors = [];
                e.preventDefault();

                this.errorContent = '';
                this.errorSubject = '';

                if (this.subject.length < 1) {
                    this.errorSubject = 'A subject is required';
                    errors.push(this.errorSubject);
                }

                if (this.content.length < 1) {
                    this.errorContent = 'A message is required';
                    errors.push(this.errorContent);
                }

                if (!errors.length) {
                    this.$emit('send', this.subject, this.content);
                    this.content = '';
                    this.subject = '';
                }
            }
        }

    }
</script>
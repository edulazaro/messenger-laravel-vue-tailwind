<template>
    <div class="view-messages">
        <MessageList :mailbox="'sent'"/>
    </div>
</template>

<script>
    import MessageList from '../components/MessageList';

    export default {
        components: {
            MessageList,
        },
    };
</script>

<script setup>
import { Head } from '@inertiajs/vue3';
import {onMounted, ref} from "vue";

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}

let messages = ref([])
const channel = window.Echo.channel("test-channel");

onMounted(() => {
    /**
     * Testing Channels & Events & Connections
     */
    channel.listen("SendMessage", (event) => {
        messages.value.push(event.data)
        console.log(event)
    });

})
let messageData = ref('')
function sendPackage() {
    Echo.connector.pusher.send_event(
        'SendMessage',   // Event Name
        JSON.stringify({message : messageData.value}),  // data
        `test-channel`,  // channel
    );
}

</script>

<template>
    <Head title="Welcome" />

    <input type="text" v-model="messageData" class="border-2 border-gray-500" />

    <button @click="sendPackage" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Button
    </button>

    <ul class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400">
        <li v-for="message in messages" :key="message.id" @click="messages.splice(messages.indexOf(message), 1)">
            {{ message }}
        </li>
    </ul>
</template>

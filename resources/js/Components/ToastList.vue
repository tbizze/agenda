<!-- CRÉDITOS:
     https://www.youtube.com/watch?v=bIZBNYFXcKU&t=36s
     Canal => cdruc
-->
<script setup>
import { ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3'

import { FwbToast } from 'flowbite-vue'

const page = usePage();

const success = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])
const warning = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])
const danger = ref([
    /* {message: 'Registro salvo com sucesso.'}, */
])

// Ao terminar a renderização, verifica se há mensagens de alerta.
router.on('finish', ()=>{
    // Se há mensagem de sucesso, coloca a mensagem na variável 'success'.
    if (page.props.flash.success){
        success.value.unshift({
            message: page.props.flash.success
        });
    }
    // Se há mensagem de alerta, coloca a mensagem na variável 'warning'.
    if (page.props.flash.warning){
        warning.value.unshift({
            message: page.props.flash.warning
        });
    }
    // Se há mensagem de erro, coloca a mensagem na variável 'danger'.
    if (page.props.flash.danger){
        danger.value.unshift({
            message: page.props.flash.danger
        });
    }
})
</script>
<template>
    <div class="fixed top-10 right-10 z-50 space-y-3 w-full max-w-xs ">
        <!-- ### Success: Mensagens de sucesso -->
        <FwbToast
            v-for="(item, index) in success"
            :key="index"
            :message="item.message"
            type="success"
            closable
            class="border border-l-4 border-l-green-400 rounded-md shadow-sm"
        >{{ item.message }}</FwbToast>

        <!-- ### Warning: Mensagens de alerta -->
        <FwbToast
            v-for="(item, index) in warning"
            :key="index"
            :message="item.message"
            type="warning"
            closable
            class="border border-l-4 border-l-orange-400 rounded-md shadow-sm"
        >{{ item.message }}</FwbToast>

        <!-- ### Danger: Mensagens de erro -->
        <FwbToast
            v-for="(item, index) in danger"
            :key="index"
            :message="item.message"
            type="danger"
            closable
            class="border border-l-4 border-l-red-500 rounded-md shadow-sm"
        >{{ item.message }}</FwbToast>
    </div>
</template>
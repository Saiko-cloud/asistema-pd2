<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Student
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="h-3/5 w-full">
                        <div class="h-full p-2 inline-grid grid-cols-5 gap-x-4">
                                <div class="col-span-5 inline-grid grid-cols-5 gap-x-4 mt-3" >
                                        <h1 class="my-auto mx-3">Nr.</h1>
                                        <h1 class="my-auto mx-3">Name</h1>
                                        <h1 class="my-auto mx-3">Note</h1>
                                        <h1></h1>
                                </div>

                                <div  class="col-span-5 inline-grid grid-cols-5 gap-x-4 border mb-1" v-for="(data, index) in notes" :key="data.id">
                                        <h1 class="my-auto mx-3">{{index+1}}</h1>
                                        <h1 class="my-auto mx-3">{{data.name}}</h1>
                                        <h1 class="my-auto mx-3">{{data.pivot.note}}</h1>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>

    import AppLayout from '@/Layouts/AppLayout.vue'

    export default ({
        components: {
            AppLayout,
        },
        data: function(){
            return {
                notes: []
            }
        },

        methods:{
            getNotes()
            {
                axios.get('/getNotes', {

                    })
                    .then( response => {
                        this.notes = response.data;
                        console.log(response.data);
                    })
                    .catch ( error => {
                        console.log( error );
                    })
            }
        },
        mounted(){
            this.getNotes();
        },

    })
</script>

<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Teacher
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
                                        <h1 class="my-auto mx-3">Surname</h1>
                                        <h1 class="my-auto mx-3">Group</h1>
                                        <h1 class="my-auto mx-3">Note</h1>
                                        <h1></h1>
                                </div>

                                <div  class="col-span-5 inline-grid grid-cols-5 gap-x-4 border mb-1" v-for="(data, index) in students" :key="data.id">
                                        <h1 class="my-auto mx-3">{{index+1}}</h1>
                                        <h1 class="my-auto mx-3">{{data.name}}</h1>
                                        <h1 class="my-auto mx-3">{{data.surname}}</h1>
                                        <h1 class="my-auto mx-3">{{data.group}}</h1>
                                        <h1 @click="changeNote(data.pivot.lesson_id,data.id)" v-if="data.pivot.note == 'Neįvertinta' " class="text-red-500 my-auto mx-3">{{data.pivot.note}}</h1>
                                        <h1 @click="changeNote(data.pivot.lesson_id,data.id)" v-else class="text-green-500 my-auto mx-3">{{data.pivot.note}}</h1>
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

    import Swal from 'sweetalert2'
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
        })

    export default ({
        components: {
            AppLayout,
        },
        data: function(){
            return {
                students: []
            }
        },
        methods: {
            getStudents()
            {
                axios.get('/getStudents', {

                    })
                    .then( response => {
                        this.students = response.data;
                        console.log(response.data);
                    })
                    .catch ( error => {
                        console.log( error );
                        Toast.fire({
                            icon: 'error',
                            title: 'Error'
                            })
                    })
            },
            async changeNote(lessonID, studentID)
            {
                const { value: text } = await Swal.fire({
                input: 'text',
                inputLabel: 'Note Change',
                inputValue: '',
                inputPlaceholder: '10',
                inputAttributes: {
                    'aria-label': '10'
                },
                confirmButtonColor: '#2ab27b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Change',
                showCancelButton: true
                })
                if (text) {
                    axios.post('/changeNote', {
                        lessonID: lessonID,
                        studentID: studentID,
                        note: text,
                    })
                    .then( response => {
                        if(response.status == 200)
                        {
                            Toast.fire({
                            icon: 'success',
                            title: 'Note successfully changed'
                            })
                            this.getStudents();
                        }
                    })
                    .catch ( error => {
                        console.log( error );
                        Toast.fire({
                            icon: 'error',
                            title: 'Error'
                            })
                    })
                }
            },

        },
        mounted(){
            this.getStudents();

        }
    })
</script>

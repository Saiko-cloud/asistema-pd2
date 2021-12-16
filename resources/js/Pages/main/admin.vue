<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Admin
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="h-3/5 w-full">
                        <div class="h-full p-2 inline-grid grid-cols-5 gap-x-4">            
                            <button
                                @click="createLesson()"
                                class="bg-green-400 hover:bg-green-500 py-2 px-8 mt-1 rounded text-white">
                                Create new Lesson
                            </button>   
                            <button
                                @click="newUser('admin')"
                                class="bg-red-400 hover:bg-red-500 py-2 px-8 mt-1 rounded text-white">
                                Add new Admin
                            </button>  
                            <button
                                @click="newUser('teacher')"
                                class="bg-yellow-400 hover:bg-yellow-500 py-2 px-8 mt-1 rounded text-white">
                                Add new Teacher
                            </button>  
                            <button
                                @click="newUser('student')"
                                class="bg-blue-400 hover:bg-blue-500 py-2 px-8 mt-1 rounded text-white">
                                Add new Student
                            </button>  
                            
                        <div class="col-span-5 mt-5 inline-grid grid-cols-5 gap-x-4">
                            <button
                                @click="loadData('users')"
                                class="bg-purple-400 hover:bg-purple-500 py-2 px-8 mt-1 rounded text-white">
                                Load All Users
                            </button>  
                            <button
                                @click="loadData('lessons')"
                                class="bg-purple-400 hover:bg-purple-500 py-2 px-8 mt-1 rounded text-white">
                                Load All Lessons
                            </button>  
                        </div>
                        

                        <template v-if="currentDataType == 'lessons' ">
                            <div class="col-span-3 inline-grid grid-cols-3 gap-x-4 mt-3" >
                                    <h1 class="my-auto ml-3">Name</h1>
                                    <h1 class="my-auto ml-3">Group</h1>
                                    <h1></h1>
                            </div>

                            <div  class="col-span-3 inline-grid grid-cols-3 gap-x-4 border mb-1" v-for="(data) in adminData" :key="data.id">
                                    <h1 @click="changeData(data.role,'name',data.name,data.id)" class="my-auto ml-3">{{data.name}}</h1>
                                    <h1 @click="changeData(data.role,'group',data.group,data.id)" v-if="data.group == 'Missing' " class="my-auto ml-3 text-red-500">{{data.group}}</h1>
                                    <h1 @click="changeData(data.role,'group',data.group,data.id)" v-else class="my-auto ml-3">{{data.group}}</h1>
                                    <button
                                    @click="deleteData(data.id)"
                                    class="bg-red-700 hover:bg-red-800 py-1 px-2 ml-auto mr-2 mt-1 mb-1 rounded text-white">
                                    Delete
                                </button> 
                            </div>
                        </template>

                        <template v-if="currentDataType == 'users' ">
                            <div class="col-span-5 inline-grid grid-cols-5 gap-x-4 mt-3" >
                                    <h1 class="my-auto ml-3">Name</h1>
                                    <h1 class="my-auto ml-3">Surname</h1>
                                    <h1 class="my-auto ml-3">Role</h1>
                                    <h1 class="my-auto ml-3">Group / Lesson</h1>
                                    <h1></h1>
                            </div>

                            <div  class="col-span-5 inline-grid grid-cols-5 gap-x-4 border mb-1" v-for="(data) in adminData" :key="data.id">
                                    <h1 @click="changeData(data.role,'name',data.name,data.id)" class="my-auto ml-3">{{data.name}}</h1>
                                    <h1 @click="changeData(data.role,'surname',data.surname,data.id)" v-if="data.surname == 'Missing' " class="my-auto ml-3 text-red-500">{{data.surname}}</h1>
                                    <h1 @click="changeData(data.role,'surname',data.surname,data.id)" v-else class="my-auto ml-3">{{data.surname}}</h1>
                                    <h1 @click="changeData(data.role,'role',data.role,data.id)" v-if="data.role == 'Missing' " class="my-auto ml-3 text-red-500">{{data.role}}</h1>
                                    <h1 @click="changeData(data.role,'role',data.role,data.id)" v-else class="my-auto ml-3">{{data.role}}</h1>
                                    <h1 @click="changeData(data.role,'group',data.group,data.id)" v-if="data.group == 'Missing' " class="my-auto ml-3 text-red-500">{{data.group}}</h1>
                                    <h1 @click="changeData(data.role,'group',data.group,data.id)" v-else class="my-auto ml-3">{{data.group}}</h1>
                                    <button
                                    @click="deleteData(data.id)"
                                    class="bg-red-700 hover:bg-red-800 py-1 px-2 ml-auto mr-2 mt-1 mb-1 rounded text-white">
                                    Delete
                                </button> 
                            </div>
                        </template>


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
                adminData: [],
                currentDataType: ''
            }
        },

        methods:{
            deleteData(id)
            {
                axios.post('/deleteData', {
                        id: id,
                        dataType: this.currentDataType,
                        
                    })
                    .then( response => {
                        if(response.status == 200)
                        {
                            Toast.fire({
                            icon: 'success',
                            title: 'Data successfully deleted'
                            })
                            this.loadData(this.currentDataType);
                        }
                    })
                    .catch ( error => {
                        console.log( error );
                        Toast.fire({
                            icon: 'error',
                            title: 'Error'
                            })
                    })
            },
            async changeData(role,type,data,id)
            {
                const { value: text } = await Swal.fire({
                input: 'text',
                inputLabel: type+' change',
                inputValue: data,
                inputPlaceholder: '',
                inputAttributes: {
                    'aria-label': ''
                },
                confirmButtonColor: '#2ab27b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Change',
                showCancelButton: true
                })
                if (text) {
                    axios.post('/changeData', {
                        dataType: this.currentDataType,
                        type: type,
                        data: text,
                        id: id,
                        role: role,
                    })
                    .then( response => {
                        if(response.status == 200)
                        {
                            Toast.fire({
                            icon: 'success',
                            title: 'Data successfully changed'
                            })
                            this.loadData(this.currentDataType);
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
            loadData(type){
                axios.post('/getAdminData', {
                        type: type
                    })
                    .then( response => {
                        this.adminData = response.data;
                        this.currentDataType = type;
                    })
                    .catch ( error => {
                        console.log( error );
                        Toast.fire({
                            icon: 'error',
                            title: 'Error'
                            })
                    })
            },
            async createLesson()
            {
                const { value: text } = await Swal.fire({
                input: 'text',
                inputLabel: 'New Lesson name?:',
                inputValue: '',
                inputPlaceholder: 'Math',
                inputAttributes: {
                    'aria-label': 'Math'
                },
                confirmButtonColor: '#2ab27b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Create',
                showCancelButton: true
                })
                if (text) {
                    axios.post('/newLesson', {
                        name: text
                    })
                    .then( response => {
                        if(response.status == 200)
                        {
                            Toast.fire({
                            icon: 'success',
                            title: 'Lesson successfully created'
                            })
                            if(this.currentDataType == "lessons")
                            {
                                this.loadData('lessons');
                            }
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
                else
                {

                }
            },
            async newUser(role)
            {
                const { value: text } = await Swal.fire({
                input: 'text',
                inputLabel: 'Enter '+role+' name and surname:',
                inputValue: '',
                inputPlaceholder: 'Jonas Jonaitis',
                inputAttributes: {
                    'aria-label': 'Jonas Jonaitis'
                },
                confirmButtonColor: '#2ab27b',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Add',
                showCancelButton: true
                })
                if (text) {
                    axios.post('/newUser', {
                        name: text,
                        role: role
                    })
                    .then( response => {
                        if(response.status == 201)
                        {
                            Toast.fire({
                            icon: 'success',
                            title: 'New User successfully added'
                            })
                            if(this.currentDataType == "users")
                            {
                                this.loadData('users');
                            }
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
                else
                {

                }
            },

        },




    })
</script>

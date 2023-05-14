<template>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-12">
          <input type="text" placeholder="Buscar usuario" />
          <table class="table table-bordered" with="100%">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Estado</th>
                <th scope="col" v-if="can('edit-users | change-status-users') || is('admin')">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(user, index) in users.data" :key="index">
                <td scope="col">{{ user.id }}</td>
                <td scope="col">{{ user.name }}</td>
                <td scope="col">{{ user.email }}</td>
                <td scope="col">{{ (user.status)?"Activo":"Inactivo" }}</td>
                <button  type="button" class="btn btn-danger" @click="changeStatus(user.id, user.status)" v-if="can('change-status-users') || is('admin')">Inhabilitar</button>
                <button  type="button" class="btn btn-secondary" v-if="can('edit-users') || is('admin')">Editar</button>
              </tr>
            </tbody>
          </table>
          <paginator :current_page="users.current_page" :last_page="users.last_page" :on-page-change="changePage"/>
  
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        users: {},
        current_page:1,
        last_page:0
      };
    },
    created() {
      this.fetchUser();
    },
    methods: {
      async fetchUser(page=1) {
        const response = await axios.get(`usuarios/all?page=${page}`);
        this.users = response.data;
        this.current_page = response.data.current_page;
        this.last_page = response.data.last_page
      },
      async changeStatus(id,status){
          const response = await axios.put("usuarios/update_status/"+id,{
              status:(!status)?1:0
          });
          this.fetchUser()
      },
      changePage(page){
          this.fetchUser(page)
      }
    },
  };
  </script>
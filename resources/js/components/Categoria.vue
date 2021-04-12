<template>
        <!-- Main content -->
      <!-- Default box -->
      <main class="main">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Categorías</h3>
          <button @click="abrirModal('categoria','registrar')" type="button" class="btn btn-secondary">
              <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
        
          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              <i class="fas fa-times"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="display" style="width:100%" id="tabla">
              <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 30%">
                          Nombre
                      </th>
                      <th style="width: 30%">
                          Descripción
                      </th>
                      <th style="width: 20%">
                          Estado
                      </th>
                      <th style="width: 19%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="categoria in arrayCategoria" :key="categoria.id">
                      <td>
                          #
                      </td>
                      <td>
                          <a v-text="categoria.nombre">
                          </a>
                          <br/>
                          <small v-text="categoria.created_at">
                            Creado 
                          </small>
                      </td>
                      <td v-text="categoria.descripcion">
                         
                      </td>
                      <td class="project-state">
                          <div v-if="categoria.condicion">
                              <span class="badge badge-success">Activo</span>
                          </div>
                          <div v-else>
                              <span class="badge badge-danger">Desactivado</span>
                          </div>
                      </td>
                      <td class="project-actions text-right">
                          <!--<a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              Ver
                          </a>
                          -->
                          <a class="btn btn-info btn-sm" href="#" @click="abrirModal('categoria','actualizar',categoria)">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Editar
                          </a>
                            <a v-if="categoria.condicion" class="btn btn-danger btn-sm" href="#" @click="desactivarCategoria(categoria.id)">
                                <i class="fas fa-trash">
                                </i>
                                Desactivar
                            </a>
                            <a v-else class="btn btn-info btn-sm" href="#" @click="activarCategoria(categoria.id)">
                                <i class="fas fa-check">
                                </i>
                                Activar
                            </a>
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->


      </div>
      <!-- /.card -->


        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" id="modalNuevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" :class="{'mostrar' : modal}" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <h4 class="modal-title" v-text="tituloModal" ></h4>
                        <button @click="cerrarModal()" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                               <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="descripcion" class="form-control" placeholder="Descripción Categoria">
                                </div>
                            </div>
                            <div v-show="errorCategoria" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjCategoria" :key="error" v-text="error">

                                    </div>
                                </div>
                            
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button @click="cerrarModal()" type="button" class="btn btn-secondary">Cerrar</button>
                        <button @click="registrarCategoria()" v-if="tipoAccion==1" type="button" class="btn btn-primary" >Guardar</button>
                        <button @click="actulizarCategoria()" v-if="tipoAccion==2" type="button" class="btn btn-primary" >Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->

        </div>
        <!--Fin del modal-->
      </main>

      
</template>

<script>
    export default {
        data (){
            return{
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                categoria_id : 0,
                nombre : '',
                descripcion : '',
                arrayCategoria : [],
                errorCategoria : 0,//Determinar si hay o no errores
                errorMostrarMsjCategoria : []
            }
        },
        methods : {
            listarCategoria (){//Declrar todas las funciones
                let me = this;
               //alert('Listar Categoria');
               // Make a request for a user with a given ID
                axios.get('/categoria').then(response => {
                    me.arrayCategoria = response.data
                    this.tabla();//Cargar el DataTable
                    // handle success
                    console.log(me.arrayCategoria);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            tabla (){//DataTable
            this.$nextTick(()=>{
                $('#tabla').DataTable();//Llamar el DataTable
            })
            },
            abrirModal(modelo,accion,data = []){
                switch(modelo){
                    case "categoria":
                    {
                        switch(accion){
                            case "registrar":
                            {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Categoria';
                            this.nombre = '';
                            this.descripcion = '';
                            this.tipoAccion = 1;
                            this.errorCategoria = 0;
                            break;
                            }

                            case "actualizar":
                            {
                            this.modal = 1;
                            this.tituloModal = 'Actualizar Categoria';
                            this.categoria_id = data['id'];
                            this.nombre = data['nombre'];
                            this.descripcion = data['descripcion'];
                            this.tipoAccion = 2;
                            this.errorCategoria = 0;
                            break;
                            }
                        }
                        break;
                    }
                }
            },
            cerrarModal(){
                this.modal = 0;//VAriable para cerrar el modal
                this.tituloModal = '';
                this.nombre = '';
                this.descripcion = '';
            },
            registrarCategoria(){
                if(this.validarCategoria()){
                    return;
                }

                let me = this;
                axios.post('/categoria/registrar',{
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria();
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            actulizarCategoria(){
                if(this.validarCategoria()){
                    return;
                }

                let me = this;
                axios.put('/categoria/actualizar',{
                    'id' : this.categoria_id,
                    'nombre' : this.nombre,
                    'descripcion' : this.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarCategoria();
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            validarCategoria(){
                this.errorCategoria = 0;
                this.errorMostrarMsjCategoria = [];
                
                if (!this.nombre) this.errorMostrarMsjCategoria.push("Nombre de la categoria no puede estar vacio");

                if(this.errorMostrarMsjCategoria.length) this.errorCategoria = 1;//Mostrar el error

                return this.errorCategoria;
            },
            desactivarCategoria(id){
                let me = this;
                axios.put('/categoria/desactivar',{
                    'id' : id
                })
                .then(function (response) {
                    me.listarCategoria();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            },
            activarCategoria(id){
                let me = this;
                axios.put('/categoria/activar',{
                    'id' : id
                })
                .then(function (response) {
                    me.listarCategoria();
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
            }
        },
        mounted() {
            //console.log('Component mounted.')
            this.listarCategoria();
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        margin-top: 50px;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;/*Distribuir div a la pantalla principal*/
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>
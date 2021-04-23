<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
              
                       <form @submit.prevent="register" class="form-inline">
                        <div class="form-group mb-2">
                            <label for="staticEmail2" class="sr-only">Email</label>
                            <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="Ingrese su codigo">
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="codigo" class="sr-only">codigo</label>
                            <input type="text" v-model="codigo" class="form-control" id="codigo" placeholder="Codigo" required>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Registrar</button>
                        </form>
                        {{algo}}
           </div>   
        </div>
    </div>
</template>

<script>
 import Conf from '../conf.js'; ///INFORMACION DEL SERVIDOR
 import CxltToastr from 'cxlt-vue2-toastr'



    import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';
    Vue.use(CxltToastr)
    var toastrConfigs = {
        position: 'top right',
        showDuration: 8000,
        progressBar: true,
    }
    Vue.use(CxltToastr, toastrConfigs)
    /* *** FIN MENSAJE TOAST *** */

 const server = Conf.server;
    export default {
        data(){
            return{
                codigo:"",
                userInf:[],
                algo:"",
            }
        },
        methods:{
            getUserInformation(){
                axios.get(server+'/getUserInforation/2').then(response => (this.userInf=response.data)
                )
            },

            register(){
                let datos = {
                codigo:this.codigo,
            };
                axios.post(server+'/getEntradasSalidas', datos).then(response => (this.algo=response.data)
                
                )
                if(this.algo!='ok'){
                   this.$toast.error({
                                title: this.algo,
                                message: this.algo,
                                progressBar: true,
                                position: "top right"})
                     
                }else{
                   this.$toast.success({
                                title: "Success",
                                message: this.algo,
                                progressBar: true,
                                position: "top right"})
                }
                    
             
            }
        },
        mounted() {
           this.getUserInformation();
        }
    }
</script>

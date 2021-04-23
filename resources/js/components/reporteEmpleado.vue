<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div v-for="item in reportes" :key="item.fechareg" class="card">
                    <div class="card-header"> {{ moment(item.fechareg, "YYYY-MM-DD").format( "MMM DD YYYY, ddd" ) }}</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">Nombres</th>
                                <th scope="col">Entrada</th>
                                <th scope="col">Almuerzo Inicio</th>
                                <th scope="col">AlmuerzoRegreso</th>
                                <th scope="col">Salida</th>
                                <th scope="col">Cumplimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="datos in item.registros" :key="datos.esId">
                                <th scope="row">{{datos.name}} {{datos.apellido}}</th>
                                <td>{{datos.entrada}}</td>
                                <td>{{datos.almuerzo}}</td>
                                <td>{{datos.LLegadalmuerzo}}</td>
                                <td>{{datos.salida}}</td>
                                 <td>{{obtenerCumplimiento(datos.entrada,datos.salida,datos.almuerzo,datos.LLegadalmuerzo)}}</td>
                                </tr>
                                
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
            {{}}
        </div>
    </div>
</template>

<script>
import Conf from '../conf.js'; ///INFORMACION DEL SERVIDOR
 import {ServerTable, ClientTable, Event} from 'vue-tables-2';
 import moment from "moment";
    Vue.use(ClientTable);
    Vue.use(require('vue-moment'));
const server = Conf.server;
    export default {
        props: ["us_id"],
        data(){
            return{
                reportes:[],
                 moment: moment,
            }
        },
        methods:{
            getAll(){
                axios.get(server+'/getESRegistersByUsId/'+this.us_id).then(response => (this.reportes=response.data)
                )
            },
            obtenerCumplimiento(legada,salida,almuerzo,llegadaAlm){
                var lleg = moment(legada,'HH:mm');
                var sali = moment(salida,'HH:mm');
                 var alm = moment(almuerzo,'HH:mm');
                var llegAlm = moment(llegadaAlm,'HH:mm');
                var durat=moment.duration(sali - lleg);
                var duracionAlm=moment.duration(llegAlm - alm);
                var total=moment.duration(durat - duracionAlm);
               // console.log(durat.format("HH:mm"));
                  return total//  moment.duration(lunch - breakfast).humanize();
            }
        },
        mounted() {
            this.getAll();
        }
    }
</script>
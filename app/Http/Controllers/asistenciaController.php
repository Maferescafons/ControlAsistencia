<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Metadata;
use App\EntradaSalida;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class asistenciaController extends Controller
{
    public function index(){
        return view('asistencia.index');
    }
    public function getUserInforation($userId){
        $user=User::find($userId);
        return response()->json($user) ;
    }
    public function registrarEntradasSalidas(Request $request){
        $data = request()->all();
       
        $fechaHoraReg=date('yy-m-d H:i:s');

        $registro=EntradaSalida::where('fecha',Carbon::now()->format('Y-m-d'))->count();

        switch ($registro) {
              case 0://preconfirm
              $tipo='entrada';
                break;
              case 1://confirmadoConPago
                $tipo='Salida Almuerzo'; 
                break;
              case 3://Allowment
                $tipo='Entrada Almuerzo'; 
                break;
              case 4:
                $tipo='Salida';  
                break;
                          
            default:
           // $filebox->vslId = $id;
          }
          

    }
    public function getEntradasSalidas(Request $request){
        $data = request()->all();
        //789456

      
      
                    $ultimoRegistro=EntradaSalida::select('users.id','entradasalida.fecha','entradasalida.orden')
                                            ->join('users as users', 'users.id', '=', 'entradasalida.id')
                                            ->whereDate('fecha',Carbon::now()->format('Y-m-d'))
                                            ->where('users.codigo',$data['codigo'])
                                            ->orderBy('fecha','desc')->first();

      if($ultimoRegistro){
        $fecha2=Carbon::now()->toDateTimeString();
            
        // fecha1 en este caso es la fecha actual
        $fecha1= $ultimoRegistro->fecha;

        $dif = $this->minutosTranscurridos($fecha2,$fecha1);
       // return response()->json($dif);
        $registros=EntradaSalida::whereDate('fecha',Carbon::now()->format('Y-m-d'))->count();

        if($dif>10){
            switch ($registros) {
                case 0://1
                $tipo='entrada';
                $datos=['id'=>$ultimoRegistro->id,
                        'fecha' => $fecha2,
                        'tipo' => 1,
                        'orden'=>$ultimoRegistro->orden+1
                    ];
                break;
                case 1://confirmadoConPago
                $tipo='Salida Almuerzo';
                $datos=['id'=>$ultimoRegistro->id,
                        'fecha' => $fecha2,
                        'tipo' => 2,
                        'orden'=>$ultimoRegistro->orden+1];

                $this->registrarEntradaSalida($datos);
                return response()->json('ok');
                
                break;
                case 3://Allowment
                $tipo='Entrada Almuerzo'; 
                $datos=['id'=>$ultimoRegistro->id,
                        'fecha' => $fecha2,
                        'tipo' => 3,
                        'orden'=>$ultimoRegistro->orden+1];
                        $this->registrarEntradaSalida($datos);
                        return response()->json('ok');
                break;
                case 4:
                $tipo='Salida';
                $datos=['id'=>$ultimoRegistro->id,
                        'fecha' => $fecha2,
                        'tipo' => 4,
                        'orden'=>$ultimoRegistro->orden+1];  
                        $this->registrarEntradaSalida($datos);
                        return response()->json('ok');
                break;
                            
            default:
            $datos=['id'=>$ultimoRegistro->id,
            'fecha' => $fecha2,
            'tipo' => 4,
            'orden'=>$ultimoRegistro->orden+1]; 
            $this->registrarEntradaSalida($datos);
            return response()->json('ok');
            }
        }else{
            return response()->json('ya ha sido registrado');
        }
      }else{
        $empleado=User::where('users.codigo',$data['codigo'])->first();
        if($empleado){
            $datos=['id'=>$empleado->id,
            'fecha' => Carbon::now()->toDateTimeString(),
            'tipo' => 1,
            'orden' =>1]; 
            $this->registrarEntradaSalida($datos);
            return response()->json('ok');
        }else{
            return response()->json('No existe empleado');
        }
       
      }
                
        
       
      

       
       // return response()->json($dif);
    }

    function minutosTranscurridos($fecha_i,$fecha_f)
            {
            $minutos = (strtotime($fecha_i)-strtotime($fecha_f))/60;
            $minutos = abs($minutos); $minutos = floor($minutos);
            return $minutos;
            }

function registrarEntradaSalida($datos)
    {
        
        $entradaSalida = new EntradaSalida;
        $entradaSalida->id = $datos['id'];
        $entradaSalida->fecha = $datos['fecha'];
        $entradaSalida->tipo = $datos['tipo'];
        $entradaSalida->orden = $datos['orden'];
        $entradaSalida->save();
    }

    function primerRegistro($datos)
    {
        
        $entradaSalida = new EntradaSalida;
        $entradaSalida->id = $datos['id'];
        $entradaSalida->fecha = $datos['fecha'];
        $entradaSalida->tipo = $datos['tipo'];
        $entradaSalida->orden = $datos['orden'];
        $entradaSalida->save();
    }
    public function getMetadataByGroup($met_group)
    {
        $data =Metadata::select('metadata.metName','metadata.metCodigo','metAuxiliar')
        ->where('metGroup',$met_group)
        ->orderBy('metadata.metCodigo')
        ->pluck('metName','metCodigo');

        return response()->json($data);
    }
    public function getAllESRegisters()
    {
        $reporte = array();
        $i = 0;

        $data =EntradaSalida::Select(DB::raw('DATE(entradasalida.fecha) fechareg') )
       ->groupBy('fechareg') 
       ->orderBy('fechareg','asc') 
        ->get();

        foreach($data as $datos) {
            $reporte[$i]['fechareg']=$datos->fechareg;
            $reporte[$i]['registros']=EntradaSalida::Select('entradasalida.*','users.name','users.apellido',
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.orden=1 LIMIT 1) entrada"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.orden=MAX(DISTINCT entradasalida.orden) LIMIT 1) salida"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.tipo=2 LIMIT 1) almuerzo"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.tipo=3 LIMIT 1) LLegadalmuerzo")
            )
            ->join('users as users', 'users.id', '=', 'entradasalida.id')
            ->whereDate('fecha',$datos->fechareg)->groupBy('users.id')->get();
            $i++;
         }
        return response()->json($reporte);
    }
    public function getESRegistersByUsId($usId)
    {
        $reporte = array();
        $i = 0;

        $data =EntradaSalida::Select(DB::raw('DATE(entradasalida.fecha) fechareg') )
       ->groupBy('fechareg') 
       ->orderBy('fechareg','asc') 
        ->get();

        foreach($data as $datos) {
            $reporte[$i]['fechareg']=$datos->fechareg;
            $reporte[$i]['registros']=EntradaSalida::Select('entradasalida.*','users.name','users.apellido',
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.orden=1 LIMIT 1) entrada"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.orden=MAX(DISTINCT entradasalida.orden) LIMIT 1) salida"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.tipo=2 LIMIT 1) almuerzo"),
            DB::raw("(SELECT TIME(entS.fecha) FROM entradasalida entS 
            WHERE entS.id=users.id AND DATE(entS.fecha)=DATE(entradasalida.fecha) AND entS.tipo=3 LIMIT 1) LLegadalmuerzo")
            )
            ->join('users as users', 'users.id', '=', 'entradasalida.id')
            ->whereDate('fecha',$datos->fechareg)->groupBy('users.id')
            ->where('users.id',$usId)
            ->get();
            $i++;
         }
        return response()->json($reporte);
    }
}

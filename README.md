composer create-project    laravel/laravel  --prefer-dist  C:\xampp\htdocs\projetoum

1) create database BDservico;
use  BDservico;
.env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=BDservico
DB_USERNAME=root
DB_PASSWORD=coti


php artisan make:model  Models/Cliente


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable= ['nome','email','foto'];
    protected $table="clientes";  
}

===============


//============================

php artisan make:migration  clientes

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class Clientes extends Migration
{
    public function up()
    {
       Schema::create('clientes', function(Blueprint $table){
            $table->increments("id");
            $table->string("nome",50);
            $table->string("email",50)->unique();
            $table->string("foto");
            $table->timestamps();
       });
    }

    
    public function down()
    {
        Schema::drop("clientes");
    }
}

drop table users;
drop table migrations;



php artisan migrate 

================================
drop database  BDservico;
create database BDservico;
use  BDservico;

php artisan migrate 
desc clientes;
=========================

(1 Model)
(2 migration) _ 

desc clientes;

insert into clientes values (null,'belem','belem@gmail.com','m',20,
  now(),now());

  
insert into clientes values 
(null,'lu','f',
'lu@gmail.com',20,
  now(),now());

 =============================



php artisan make:controller ClienteController


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    
    protected $clientes;
     

    public  function __construct(Cliente $cliente){
           $this->clientes = $cliente;
    }


     public function findAll(){
         $lista = Cliente::all();
         return response()->json($lista, 200);
     }

     public function findById($id){

        $cliente = Cliente::find($id);
        if($cliente){
        return response()->json(["cliente"=> $cliente], 200);
        }else{
        return response()->json(["mensagem"=> "nao encontrado...".$id], 400);
        }
    }


     public function create(Request $req){
     try{
        $cliente = new Cliente($req->all());
        $cliente->save();
        return response()->json(["msg"=> "dados gravados"], 200);
     }catch(\Exception $ex){
        return response()->json(["error-gravacao"=> "nao foi possivel gravar os dados"], 500);
     }

    }


}

=========================

web.php

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('api/findAll',['uses'=>'ClienteController@findAll']);
Route::get('api/find',['uses'=>'ClienteController@findAll']);


=========================

retirar o padrão csrf (padrão )



======

<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    
       protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}


==============
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    
    protected $addHttpCookie = true;

    protected $except = [ '*',        
    ];
}


php artisan serve --port=4477 


==============================

Cors


composer require barryvdh/laravel-cors
 
php artisan make:middleware cors

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    
    public function handle(Request $request, Closure $next)
    {
        return $next($request)
           ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, X-Token-Auth, Authorization');
    }
}


composer require barryvdh/laravel-cors	=>	/*v0.11.4*/

/*config/app.php*/ $providers
Barryvdh\Cors\ServiceProvider::class,

/*Publish barryvdh/laravel-cors package file*/
php artisan vendor:publish --provider="Barryvdh\Cors\ServiceProvider"

/*Use CORS Middleware*/	=>	/*app/Http/Kernel.php*/
protected $middlewareGroups = [
    'web' => [
       // ...
    ],

    'api' => [
        'throttle:60,1',
        'bindings',
        \Barryvdh\Cors\HandleCors::class,
    ],
];

protected $routeMiddleware = [        
        'cors' => \Barryvdh\Cors\HandleCors::class,        
];


=================


npm  i -g @ionic/cli

ionic start myapp tabs

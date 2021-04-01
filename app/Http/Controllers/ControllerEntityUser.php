<?php


namespace App\Http\Controllers;

use App\EntityUser;
use App\EntityUserComputer;
use App\EntityUserPassword;
use App\Modules\CryptoOpenSSL;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;

class ControllerEntityUser extends Controller
{
    const LIMIT_ON_PAGE = 20;
    const LIMIT_FIND_ON_PAGE = 10;

    private static $ENCRYPTION_KEY;

    public function __construct()
    {
        self::$ENCRYPTION_KEY = Config::get('cryptokey');

        $this->middleware('auth:api')->only('count', 'index', 'store', 'show', 'update', 'find', 'delete');
        $this->middleware('check.handler');
    }

    public function count() {
        $count = EntityUser::count();
        $countPages = ceil( $count / self::LIMIT_ON_PAGE);
        return response()->json([
           'countPages' => $countPages
        ]);
    }

    public function index(int $page = 1) {

        $offset = ($page * self::LIMIT_ON_PAGE) - self::LIMIT_ON_PAGE;

        $users = EntityUser::select('id','username','email','title','department')->offset($offset)->limit(self::LIMIT_ON_PAGE)
            ->orderBy('username', 'ASC')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make([
            'username' => $request->input('username'),
            'login'    => $request->input('login')
        ], [
            'username' => 'required|unique:entity_users',
            'login'    => 'required|unique:entity_users'
        ], [
            'username.required' => 'Не указано имя пользователя.',
            'username.unique'   => 'Имя пользователя занято',
            'login.required'    => 'Не указан логин.',
            'login.unique'      => 'Логин был занят.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        if ($user) {

            $entityUser = EntityUser::create([
                'user_id'        => $user->id,
                'username'       => trim($request->input('username')),
                'login'          => trim($request->input('login')),
                'email'          => trim($request->input('email')),
                'department'     => trim($request->input('department')),
                'title'          => trim($request->input('title')),
                'phone'          => trim($request->input('phone')),
                'othertelephone' => trim($request->input('othertelephone')),
                'mobile'         => trim($request->input('mobile')),
                'city'           => trim($request->input('city')),
                'street'         => trim($request->input('street')),
                'cabinet'        => trim($request->input('cabinet'))
            ]);

            if($entityUser) {
                $passwords = json_decode($request->input('passwords'));

                foreach ($passwords as $password) {
                    EntityUserPassword::create([
                        'entity_user_id' => $entityUser->id,
                        'title'          => trim($password->title),
                        'password'       => CryptoOpenSSL::encrypt(self::$ENCRYPTION_KEY, trim($password->password)),
                        'description'    => trim($password->description)
                    ]);
                }

                $computers = json_decode($request->input('computers'));

                foreach ($computers as $computer) {
                    EntityUserComputer::create([
                        'entity_user_id'  =>  $entityUser->id,
                        'operatingsystem' => trim($computer->operatingsystem),
                        'servicepack'     => trim($computer->servicepack),
                        'ipAddress'       => trim($computer->ipAddress),
                        'hostname'        => trim($computer->hostname)
                    ]);
                }

                return response()->json(['success' => true]);
            }
            return response()->json(['success' => false, 'message' => 'Ошибка при сохранении.']);
        }

        return response()->json(['success' => false, 'message' => 'Пользователь не авторизирован!']);
    }

    public function show($id) {
        $user = EntityUser::find($id);
        $user->load([
           'computers' => function($query){
               $query->select('id', 'entity_user_id', 'operatingsystem', 'servicepack', 'ipAddress', 'hostname');
           },
           'passwords' => function($query){
                $query->select('id', 'entity_user_id', 'title', 'password', 'description');
           }
        ]);

        foreach ($user->passwords as $item){
            $item->password = CryptoOpenSSL::decrypt(self::$ENCRYPTION_KEY, $item->password);
        }

        return response()->json([
           'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make([
            'username' => $request->input('username'),
            'login'    => $request->input('login')
        ], [
            'username' => 'required|unique:entity_users,id,'.$id,
            'login'    => 'required|unique:entity_users,id,'.$id
        ], [
            'username.required' => 'Не указано имя пользователя.',
            'username.unique'   => 'Имя пользователя занято',
            'login.required'    => 'Не указан логин.',
            'login.unique'      => 'Логин был занят.'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->all()]);
        }

        $user = Auth::user();

        if ($user){

            $entityUser = EntityUser::find($id);

            if (empty($entityUser)) return response()->json(['success' => false, 'message' => 'Ошибка при обновлении. Запись не найдена.']);

            $entityUser->username = trim($request->input('username'));
            $entityUser->login = trim($request->input('login'));
            $entityUser->email = trim($request->input('email'));
            $entityUser->department = trim($request->input('department'));
            $entityUser->title = trim($request->input('title'));
            $entityUser->phone = trim($request->input('phone'));
            $entityUser->othertelephone = trim($request->input('othertelephone'));
            $entityUser->mobile = trim($request->input('mobile'));
            $entityUser->city = trim($request->input('city'));
            $entityUser->street = trim($request->input('street'));
            $entityUser->cabinet = trim($request->input('cabinet'));
            $result = $entityUser->save();

            if (!$result) {
                return response()->json(['success' => false, 'message' => 'Обновить не удалось.']);
            }

            $passwords = json_decode($request->input('passwords'));

            foreach ($passwords as $password) {
                if (isset($password->id)){ //Обновить
                    $passwd = EntityUserPassword::find($password->id);
                    $passwd->title = trim($password->title);
                    $passwd->password = CryptoOpenSSL::encrypt(self::$ENCRYPTION_KEY, trim($password->password));
                    $passwd->description = trim($password->description);
                    $passwd->save();
                } else{ // Добавить новый
                    EntityUserPassword::create([
                        'entity_user_id' => $entityUser->id,
                        'title'          => trim($password->title),
                        'password'       => CryptoOpenSSL::encrypt(self::$ENCRYPTION_KEY, trim($password->password)),
                        'description'    => trim($password->description)
                    ]);
                }
            }

            $computers = json_decode($request->input('computers'));

            foreach ($computers as $computer) {
                //Обновить компьютер
                if (isset($computer->id)){
                    $comp = EntityUserComputer::find($computer->id);
                    $comp->operatingsystem = trim($computer->operatingsystem);
                    $comp->servicepack     = trim($computer->servicepack);
                    $comp->ipAddress       = trim($computer->ipAddress);
                    $comp->hostname        = trim($computer->hostname);
                    $comp->save();
                } else { // Добавить новый
                    EntityUserComputer::create([
                        'entity_user_id'  => $entityUser->id,
                        'operatingsystem' => trim($computer->operatingsystem),
                        'servicepack'     => trim($computer->servicepack),
                        'ipAddress'       => trim($computer->ipAddress),
                        'hostname'        => trim($computer->hostname)
                    ]);
                }
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Пользователь не авторизирован!']);
    }

    public function find(string $text, int $page){
//        $users = EntityUser::select('id','username','email','title','department')->where('username','like', "%$text%")
//            ->orderBy('username', 'ASC')
//            ->get();

        $offset = ($page * self::LIMIT_FIND_ON_PAGE) - self::LIMIT_FIND_ON_PAGE;

        $users = EntityUser::select('id','username','email','title','department')
            ->offset($offset)->limit(self::LIMIT_FIND_ON_PAGE)
            ->where('username','like', "%$text%")
            ->orderBy('username', 'ASC')
            ->get();


        $count = EntityUser::where('username','like', "%$text%")->count();
        $countPages = ceil( $count/ self::LIMIT_FIND_ON_PAGE);

        return response()->json([
            'users' => $users,
            'countPages' => $countPages
        ]);
    }

    public  function delete(int $id){
        $user = EntityUser::find($id);

        $user->computers()->delete();
        $user->passwords()->delete();
        $result = $user->delete();

        return response()->json([
           'success' => $result
        ]);
    }
}

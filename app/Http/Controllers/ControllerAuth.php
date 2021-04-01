<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckHandler;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ControllerAuth extends Controller
{
    const LOGIN_LDAP = 'ldap_users';//'Poplavskiy_AA';
    const PASSWORD_LDAP = 'p@ssw0rd';//'Qwerty123';

    public function __construct()
    {
        $this->middleware('auth:api')->only('logout', 'find');
    }

    public function login(Request $request){

        $login    = trim($request->input('login'));
        $password = $request->input('password');

        if (empty($login) || empty($password)) {
            return response()->json([
                'success'  => false,
                'message' => 'Не указан логин или пароль'
            ]);
        }

        $option = Config::get('ldapconfig');
        if ($option == null) {
            return response()->json([
                'success' => false,
                'message' => 'Файл настроек LDAP не обнаружен!'
            ]);
        }

        $host = $option['host'];
        $domain = $option['domain'];
        $ldapDn = $option['ldapDn'];

        $ldapConnect = ldap_connect($host);

        if ($ldapConnect) {
            ldap_set_option($ldapConnect, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConnect, LDAP_OPT_REFERRALS, 0);

            try{
                $ldapBind = ldap_bind($ldapConnect, $domain.'\\'.$login, $password);
            }catch (\Exception $ex) {
                $message = $ex->getMessage();

                if ($message == 'ldap_bind(): Unable to bind to server: Invalid credentials')
                    $message = 'Неверные учетные данные';

                return response()->json([
                   'success'  => false, 'message' => $message
                ]);
            }

            if ($ldapBind) {
                //привязка LDAP прошла успешно...
                $filter = '(&(objectClass=user)(objectCategory=person)(samaccountname=' . $login.'))';
                $sr = ldap_search($ldapConnect, $ldapDn, $filter,  ['cn', 'dn', 'mail', 'telephonenumber', 'othertelephone', 'mobile', 'department', 'title']);

                $ldapEntries = ldap_get_entries($ldapConnect, $sr);

                $username = isset($ldapEntries[0]['cn']) ? $ldapEntries[0]['cn'][0] : '';
                $email = isset($ldapEntries[0]['mail']) ? $ldapEntries[0]['mail'][0] : '';
                $phone = isset($ldapEntries[0]['telephonenumber']) ? $ldapEntries[0]['telephonenumber'][0] : '';
                $mobile = isset($ldapEntries[0]['mobile']) ? $ldapEntries[0]['mobile'][0] : '';
                $othertelephone = isset($ldapEntries[0]['othertelephone']) ? $ldapEntries[0]['othertelephone'][0] : '';
                $department = isset($ldapEntries[0]['department']) ? $ldapEntries[0]['department'][0] : '';
                $title = isset($ldapEntries[0]['title']) ? $ldapEntries[0]['title'][0] : '';

                ldap_close($ldapConnect);

                if(empty($username)){
                    return response()->json([
                        'success'  => false, 'message' => 'Пользователь не найден!'
                    ]);
                }

                $user = User::whereName($username)->first();

                if(!$user) {
                    $user = new User();
                }

                $user->password = bcrypt($password);
                $user->name = $username;
                $user->email = $email;
                $user->phone = $phone;
                $user->mobile = $mobile;
                $user->othertelephone = $othertelephone;
                $user->department = $department;
                $user->title = $title;
                $user->api_token = Str::random(60);
                $user->last_ip = $_SERVER['REMOTE_ADDR'];
                $user->user_agent = $_SERVER['HTTP_USER_AGENT'];
                $user->save();

                return response()->json([
                    'success'    => true,
                    'user_id'    => $user->id,
                    'api_token'  => $user->api_token,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'phone'      => $user->phone,
                    'mobile'     => $user->mobile,
                    'department' => $user->department,
                    'title'      => $user->title,
                    'last_ip'    => $user->last_ip,
                    'user_agent' => $user->user_agent,
                    'is_handler' => ($user->department === CheckHandler::HANDLER_DEPARTMENT) ? true : false
                ], 200);
            } else {
                //привязка LDAP не удалась...
                ldap_close($ldapConnect);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Не могу соединиться с сервером LDAP.'
        ]);
    }

    public function logout(Request $request) {
        $result = false;
        $user = $request->user();
        $headerTokenApi = $request->header('Authorization');

        if (!empty($user)) {
            $result = true;
        } elseif($headerTokenApi) {

            $user = User::where('api_token','=', str_replace('Bearer ', '', $headerTokenApi))->first();

            if (!empty($user))
                $result = true;

        } else {
            $result = false;
        }

        if ($result && !empty($user)) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json([
            'success' => $result
        ]);
    }

    public function find(string $username) {

        $option = Config::get('ldapconfig');
        if ($option == null) {
            return response()->json([
                'success' => false,
                'message' => 'Файл настроек LDAP не обнаружен!'
            ]);
        }

        $host = $option['host'];
        $domain = $option['domain'];
        $ldapDn = $option['ldapDn'];
        $ldapDnComp = $option['ldapDnComp'];

        $ldapConnect = ldap_connect($host);

        if ($ldapConnect){
            ldap_set_option($ldapConnect, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldapConnect, LDAP_OPT_REFERRALS, 0);

            try{
                $ldapBind = ldap_bind($ldapConnect, $domain.'\\'.self::LOGIN_LDAP, self::PASSWORD_LDAP);
            }catch (\Exception $ex) {
                $message = $ex->getMessage();

                if ($message == 'ldap_bind(): Unable to bind to server: Invalid credentials')
                    $message = 'Неверные учетные данные';

                return response()->json([
                    'success'  => false, 'message' => $message
                ]);
            }

            if ($ldapBind) {
                //привязка LDAP прошла успешно...
                $filter = '(&(objectClass=user)(objectCategory=person)(cn=*' . trim($username) . '*))'; //sAMAccountName
                $sr = ldap_search($ldapConnect, $ldapDn, $filter, ['cn', 'dn', 'mail', 'telephonenumber', 'othertelephone', 'mobile', 'department', 'title','samaccountname', 'company', 'l', 'streetaddress']); //* 'cn', 'dn', 'mail', 'telephonenumber', 'othertelephone', 'mobile', 'department', 'title','samaccountname', 'company', 'l', 'streetaddress'

                $ldapEntries = ldap_get_entries($ldapConnect, $sr);

                $users = [];

                foreach ($ldapEntries as $entry) {
                    if (is_array($entry)) {
                        $username = isset($entry['cn']) ? $entry['cn'][0] : '';
                        $login = isset($entry['samaccountname']) ? $entry['samaccountname'][0] : '';
                        $email = isset($entry['mail']) ? $entry['mail'][0] : '';
                        $phone = isset($entry['telephonenumber']) ? $entry['telephonenumber'][0] : '';
                        $mobile = isset($entry['mobile']) ? $entry['mobile'][0] : '';
                        $othertelephone = isset($entry['othertelephone']) ? $entry['othertelephone'][0] : '';
                        $department = isset($entry['department']) ? $entry['department'][0] : '';
                        $title = isset($entry['title']) ? $entry['title'][0] : '';
                        $company = isset($entry['company']) ? $entry['company'][0] : '';
                        $city = isset($entry['l']) ? $entry['l'][0] : '';
                        $street = isset($entry['streetaddress']) ? $entry['streetaddress'][0] : '';

                        $filter = '(&(objectClass=user)(objectCategory=computer)(description=' . $username . '*))';
                        $sr = ldap_search($ldapConnect, $ldapDnComp, $filter, ['cn', 'description', 'operatingsystem', 'operatingsystemservicepack']); //'cn', 'description', 'name', 'objectguid', 'operatingsystem', 'operatingsystemservicepack'

                        $ldapEntriesComp = ldap_get_entries($ldapConnect, $sr);

                        $computers = [];
                        foreach ($ldapEntriesComp as $comp) {

                            $hostname = isset($comp['cn']) ? $comp['cn'][0] : '';
                            $user_hostname = isset($comp['description']) ? $comp['description'][0] : '';
                            $operatingsystem = isset($comp['operatingsystem']) ? $comp['operatingsystem'][0] : '';
                            $operatingsystemservicepack = isset($comp['operatingsystemservicepack']) ? $comp['operatingsystemservicepack'][0] : '';

                            if(!empty($hostname)){
                                $computers[] = [
                                    'hostname'        => $hostname,
                                    'user_hostname'   => $user_hostname,
                                    'operatingsystem' => $operatingsystem,
                                    'servicepack'     => $operatingsystemservicepack,
                                    'ipAddress'       => gethostbyname ($hostname)
                                ];
                            }
                        }

                        $users[] = [
                            'username' => $username,
                            'login' => $domain.'\\'.$login,
                            'email' => $email,
                            'phone' => $phone,
                            'mobile' => $mobile,
                            'othertelephone' => $othertelephone,
                            'department' => $department,
                            'title' => $title,
                            'company' => $company,
                            'city' => $city,
                            'street' => $street,
                            'computers' => $computers
                        ];
                    }

                }

                return response()->json([
                    'success' => true,
                    'count'   => count($users),
                    'users'   => $users
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Не могу соединиться с сервером LDAP.'
        ]);
    }
}

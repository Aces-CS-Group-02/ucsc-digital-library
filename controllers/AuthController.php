<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\exception\NotFoundException;
use app\core\Mail;
use app\core\Request;
use app\core\Response;
use app\models\LoginForm;
use app\models\PendingUser;
use app\models\RegistrationRequest;
use app\models\ResetPassword;
use app\models\User;
use app\models\UserCollection;
use app\models\Usergroup;
use app\models\UsergroupUser;
use app\models\UsersLoginCount;

class authController extends Controller
{
    public function login(Request $request)
    {
        $loginForm = new LoginForm();
        if ($request->isPOST()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $email = $loginForm->email;
                $user = new User();
                $loginDateObj = $user->getLogInDate($email);
                $loginDateArray = (array) $loginDateObj[0];
                $loginDate = $loginDateArray["DATE(log_in_time)"];
                date_default_timezone_set('Asia/Kolkata');
                $currentDate = date('Y-m-d');

                // echo '<pre>';
                // var_dump($loginDate);
                // echo '</pre>';
                $usersLoginCount = new UsersLoginCount();
                $lastDate = $usersLoginCount->getLastDate();
                // if(strcmp($loginDate,$lastDate[0]->date) == 0){
                //     echo "equal!";
                // }
                // $dateExists = $usersLoginCount->findLoginDate($loginDate);
                // echo (!($dateExists[0][0]));
                $dateObj = date_create($currentDate);
                $lastDateObj = date_create($lastDate[0]->date);
                $diff = $dateObj->diff($lastDateObj);
                // echo '<pre>';
                // var_dump($lastDateObj->format('Y-m-d'));
                // echo '</pre>';
                // $time = strtotime($lastDate[0]->date);

                // $newformat = date('Y-m-d', $time);
                // echo '<pre>';
                // var_dump($newDate);
                // echo '</pre>';
                $days = $diff->d;
                // echo '<pre>';
                // echo($days);
                // echo '</pre>';
                if ($days) {
                    for ($i = 1; $i < $days; $i++) {
                        $newDate = $lastDateObj->modify('+1 day');
                        // echo '<pre>';
                        // var_dump($newDate);
                        // echo '</pre>';
                        $date = $newDate->format('Y-m-d');
                        $count = 0;
                        $usersLoginCount->addRecord($date, $count);
                    }
                    // $loginDate = $currentDate;
                    // str_replace($loginDate,$currentDate,$loginDate);
                }
                // echo '<pre>';
                // var_dump($loginDate);
                // var_dump($lastDate[0]->date);
                // // var_dump($dateExists);
                // // var_dump(!($dateExists[0][0]));
                // echo '</pre>';
                // echo($currentDate);
                // echo ($loginDate);
                // echo ($lastDate[0]->date);
                if ($loginDate != $currentDate) {
                    // date_default_timezone_set('Asia/Kolkata');
                    // $currentDate = date('Y-m-d');
                    // echo $currentDate;
                    $currentDateExists = $usersLoginCount->findLoginDate($currentDate);
                    // var_dump($currentDateExists);
                    // echo ($currentDateExists[0][0] == '0');
                    if ($currentDateExists[0][0] == '1') {
                        // $count = $usersLoginCount->getCount($currentDate);
                        // $integerCount = array_map('intval', explode(',', $count));
                        // var_dump($count);
                        // $integerCount++;
                        $usersLoginCount->updateCount($currentDate);
                    } else {
                        $count = 1;
                        $usersLoginCount->addRecord($currentDate, $count);
                    }
                }
                // exit;
                $user->updateLogInTime($email);
                Application::$app->response->redirect('/');
                // return;
            }
        }
        return $this->render('auth/login', ['model' => $loginForm]);
    }

    public function register(Request $request)
    {

        // $user = new User();
        $pendingUser =  new PendingUser();
        if ($request->isPOST()) {
            $pendingUser->loadData($request->getBody());

            if ($pendingUser->validate()) {
                $email = $pendingUser->{"email"};

                $ucscEmailPattern = "/(.*)@(ucsc.cmb.ac.lk|stu.ucsc.cmb.ac.lk|stu.ucsc.lk)/";
                $isUcscEmail = preg_match($ucscEmailPattern, $email);
                $code = substr(md5(mt_rand()), 0, 15);
                $pendingUser->{"token"} = $code;

                if ($isUcscEmail === 1) {

                    $host = $_SERVER['HTTP_ORIGIN'];
                    $port = $_SERVER['SERVER_PORT'];
                    $subject = "Verification Email";
                    $link = "Click <a href='{$host}:{$port}/verify-email?email={$email}&token={$code}'>here</a> to verify.";
                    $body    = "<h1>Pleasy verify your email</h1><p>{$link}</p>";
                    $altBody = "this is the alt body";


                    $mail = new Mail([$email], $subject, $body, $altBody);
                    $mail->sendMail();

                    if ($pendingUser->save()) {
                        Application::$app->session->setFlashMessage('success', 'Thanks for registering, verification email sent, check your emails :)');
                        // Application::$app->response->redirect('/');
                        return $this->render('auth/registration-successful');
                    }
                } else {
                    return $this->render('auth/registration-request', ['model' => $pendingUser]);
                }
            }



            return $this->render('auth/registration', ['model' => $pendingUser]);
        }
        return $this->render('auth/registration', ['model' => $pendingUser]);
    }

    public function registerRequest(Request $request)
    {


        $registrationRequest = new RegistrationRequest();
        if ($request->isPOST()) {

            $registrationRequest->loadData($request->getBody());

            // exit();
            $file = $_FILES['verification'];

            if ($file['name']) {
                $file['name'] = preg_replace('/[\W]/', '', $registrationRequest->email);

                $path = "data/user/request/" . basename($file['name']);

                $registrationRequest->verification = $path;

                // var_dump($_FILES['verification']);
                // exit;
            }


            if ($registrationRequest->validate()) {

                $file_is_ok =  true;

                if ($file['size'] > 5000000) {
                    $registrationRequest->addError('verification', 'File size should be less tha 5 MB.');
                    $file_is_ok = false;
                }

                if (!($file['type'] == 'image/jpeg' || $file['type'] == 'image/png')) {
                    $registrationRequest->addError('verification', 'File type should be JPEG of PNG.');
                    $file_is_ok = false;
                }

                if (!$file_is_ok) {
                    return $this->render('auth/registration-request', ['model' => $registrationRequest]);
                } else if (move_uploaded_file($file['tmp_name'], $registrationRequest->verification) && $registrationRequest->save()) {
                    var_dump($file['type']);

                    Application::$app->session->setFlashMessage('success', 'Registration request successfully sent');
                    Application::$app->response->redirect('/');
                }
            }



            return $this->render('auth/registration-request', ['model' => $registrationRequest]);
        }
        return $this->render('auth/registration-request', ['model' => $registrationRequest]);
    }

    public function verifyEmail(Request $request)
    {
        if ($request->isPOST()) {
            $user = new User();

            $user->loadData($request->getBody());

            $usergroup = $_POST['usergroup'];

            $user->role_id = $user->setRoleId();


            if ($user->validate() && $user->save()) {

                if ($usergroup != "") {
                    
                    $usergroup_user = new UsergroupUser();

                    $usergroup_user->group_id = $usergroup;
                    $usergroup_user->user_reg_no = Application::$app->db->pdo->lastInsertId();

                    $usergroup_user->save();

                }

                $new_user_id = Application::$app->db->pdo->lastInsertId();

                $user_collection = new UserCollection();

                $user_collection->reg_no = $new_user_id;
                $user_collection->name = "Favourites";

                $user_collection->save();

                Application::$app->session->setFlashMessage('success', 'Thank you for registering');
                Application::$app->response->redirect('/login');
            }

            return $this->render('auth/verify-email', ['model' => $user]);
        }

        $pendingUser = new PendingUser();

        $pendingUser->loadData($request->getBody());

        $data = [];
        foreach ($_GET as $key => $value) {
            $data[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $data_keys = array_keys($data);

        $usergroup = "";

        if (in_array('usergroup', $data_keys)) {
            $usergroup = $data['usergroup'];
        }

        // echo '<pre>';
        // var_dump($data);
        // exit;

        $where = [
            'email' => $pendingUser->{"email"},
            'token' => $pendingUser->{"token"}
        ];

        $user = $pendingUser->findOne($where);

        if (!$user) throw new NotFoundException(); //throw not found exception

        return $this->render('auth/verify-email', ['model' => $user, 'usergroup' => $usergroup]);
    }

    public function forgotPassword(Request $request)
    {
        $input = new ResetPassword();

        if ($request->isPOST()) {

            $input->loadData($request->getBody());

            $input->password = substr(md5(mt_rand()), 0, 15);
            $input->confirm_password = $input->password;

            if ($input->validate()) {
                $email = $input->email;
                $token = substr(md5(mt_rand()), 0, 15);
                $subject = "Reset Password";
                $link = "Click <a href='http://localhost:8000/reset-password?email={$email}&token={$token}'>here</a> to reset your password.";
                $body    = "<h1>Reset your password</h1><p>{$link}</p>";
                $altBody = "this is the alt body";

                $input->token = $token;

                $mail = new Mail([$email], $subject, $body, $altBody);
                $mail->sendMail();

                if ($input->save()) {
                    Application::$app->session->setFlashMessage('success', 'Password reset link has been sent. Check your emails :)');
                    Application::$app->response->redirect('/');
                }
            }

            return $this->render('auth/forgot-password', ['model' => $input]);
        }

        return $this->render('auth/forgot-password', ['model' => $input]);
    }

    public function resetPassword(Request $request)
    {

        if ($request->isPOST()) {
            $input = new ResetPassword();
            $input->loadData($request->getBody());

            if ($input->validate()) {
                $where = [
                    "email" => $input->email
                ];

                $user = new User();

                $user = $user->findOne($where);

                $user->password = $input->password;
                $user->confirm_password =  $input->confirm_password;

                if ($user->update()) {

                    $resetPasswordRequest =  new ResetPassword();

                    $where = [
                        "email" => $input->email,
                        "token" => $input->token
                    ];

                    //token eka enne na


                    $resetPasswordRequest = $resetPasswordRequest->findOne($where);

                    $resetPasswordRequest->delete();

                    Application::$app->session->setFlashMessage('success', 'Yout password is changed');
                    Application::$app->response->redirect('/login');
                }
            }

            return $this->render('auth/reset-password', ['model' => $input]);
        }

        $resetPasswordRequest =  new ResetPassword();

        $resetPasswordRequest->loadData($request->getBody());

        $where = [
            "email" => $resetPasswordRequest->email,
            "token" => $resetPasswordRequest->token
        ];

        if (!$resetPasswordRequest->findOne($where)) throw new NotFoundException(); //throw not found exception

        return $this->render('auth/reset-password', ['model' => $resetPasswordRequest]);
    }


    public function logout(Request $request)
    {
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
}

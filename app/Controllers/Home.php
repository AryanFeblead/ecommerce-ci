<?php

namespace App\Controllers;

use App\Models\LoginModel;

class Home extends BaseController
{
    public function index()
    {
        return view('login/login');
    }
    public function login()
    {
        $useremail = $this->request->getPost("emp_email");
        $password =  $this->request->getPost("emp_password");
        $loginModel = new LoginModel();
        $user = $loginModel->where('customer_email', $useremail)->first();

        if ($user) {
            if ($password === $user['customer_password']) {
                session()->set([
                    'customer_id' => $user['customer_id'],
                    'customer_name' => $user['customer_name'],
                    'logged_in' => true
                ]);
                return $this->response->setJSON(["status" => "success", "message" => "User login successfully"]);
            } else {
                return $this->response->setJSON(["status" => "emp_pass_error", "message" => "Invalid password"]);
            }
        } else {
            return $this->response->setJSON(["status" => "emp_error", "message" => "User not found"]);
        }
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}

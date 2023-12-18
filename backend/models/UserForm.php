<?php

namespace backend\models;

use common\models\User;

class UserForm extends \common\models\User
{
    public string $password = '';
    public string $password_repeat = '';

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE] = ['username', 'email', 'status'];
        $scenarios[self::SCENARIO_CREATE] = ['username', 'email', 'status', 'password', 'password_repeat'];

        return $scenarios;
    }

    public function rules()
    {
        return [
            [['username', 'password', 'password_repeat'], 'string'],
            [['username', 'email'], 'required'],
            [['status'], 'in', 'range' => array_keys(self::statuses())],
            [['password'], 'compare', 'compareAttribute' => 'password_repeat'],
            [['email'], 'email'],
            [['password', 'password_repeat'], 'required', 'on' => self::SCENARIO_CREATE]
//            [[]]
        ];
    }


    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function applyForm(): bool
    {
        if (!$this->validate()) {
            return false;
        }
//        if ($user === null){
//            $user = new User();
//        }
//        $user->username = $this->username;
//        $user->email = $this->email;
        if ($this->password) {
            $this->setPassword($this->password);
        }
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();

        return $this->save(); // && $this->sendEmail($user);
    }
}
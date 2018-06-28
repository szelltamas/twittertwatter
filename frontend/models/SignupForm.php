<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'A felhasználónév nem lehet üres!'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Ez a felhasználónév már foglalt.'],
            ['username', 'string', 'min' => 6, 'max' => 55, 'tooShort'=> 'Legalább 6 karakteres a felhasználónév!', 'tooLong'=> 'Legfeljebb 55 karakteres a felhasználónév!'],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Az email cím nem lehet üres!'],
            ['email', 'email', 'message' => 'Helytelen email cím!'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Ez az email már foglalt.'],

            ['password', 'required', 'message' => 'Adj meg egy jelszót!'],
            ['password', 'string', 'min' => 6, 'tooShort'=> 'Adj meg legalább 6 karaktert!'],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();

        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->avatar = "frontend/web/profilimages/default/default.jpg";

        return $user->save() ? $user : null;
    }

    public function attributeLabels()
{
    return [
        'username' => 'Felhasználó',
        'password' => 'Jelszó',
    ];
}
}

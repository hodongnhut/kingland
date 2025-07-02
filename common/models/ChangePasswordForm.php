<?php

namespace common\models;

use Yii;
use yii\base\Model;

/**
 * ChangePasswordForm is the model behind the change password form.
 */
class ChangePasswordForm extends Model
{
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'confirmPassword'], 'required', 'message' => '{attribute} không được để trống.'],
            ['newPassword', 'string', 'min' => Yii::$app->params['user.passwordMinLength'] ?? 6, 'tooShort' => 'Mật khẩu mới phải có ít nhất {min} ký tự.'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Xác nhận mật khẩu không khớp với mật khẩu mới.'],
            ['currentPassword', 'validateCurrentPassword'],
        ];
    }

    /**
     * Validates the current password.
     * This method serves as the inline validation for current password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Yii::$app->user->identity;
            if (!$user || !$user->validatePassword($this->currentPassword)) {
                $this->addError($attribute, 'Mật khẩu hiện tại không đúng.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'currentPassword' => 'Mật khẩu hiện tại',
            'newPassword' => 'Mật khẩu mới',
            'confirmPassword' => 'Xác nhận mật khẩu mới',
        ];
    }

    /**
     * Changes user password.
     *
     * @return bool whether the password was changed successfully
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = Yii::$app->user->identity;
            $user->setPassword($this->newPassword);
            // Regenerate auth_key to invalidate old sessions for security
            $user->generateAuthKey();
            if ($user->save()) {
                // Log out all other sessions if desired (optional)
                // Yii::$app->user->logout(); // This would log out the current user too
                return true;
            }
        }
        return false;
    }
}

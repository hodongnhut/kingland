<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User; // Đảm bảo đã import model User

/**
 * Mẫu đăng ký tài khoản
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $full_name; // Thêm trường full_name
    public $phone;     // Thêm trường phone
    public $job_title_id; // Thêm trường job_title_id
    public $department_id; // Thêm trường department_id
    public $status = 10; // Đặt giá trị mặc định cho status

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // Quy tắc cho username
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Mã Nhân Viên không được để trống.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Mã Nhân Viên này đã tồn tại.'],
            ['username', 'string', 'min' => 2, 'max' => 255, 'tooShort' => 'Mã Nhân Viên phải có ít nhất 2 ký tự.', 'tooLong' => 'Mã Nhân Viên không được vượt quá 255 ký tự.'],

            // Quy tắc cho email
            ['email', 'trim'],
            ['email', 'required', 'message' => 'Email không được để trống.'],
            ['email', 'email', 'message' => 'Email không đúng định dạng.'],
            ['email', 'string', 'max' => 255, 'tooLong' => 'Email không được vượt quá 255 ký tự.'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Địa chỉ email này đã được sử dụng.'],

            // Quy tắc cho password
            ['password', 'required', 'message' => 'Mật khẩu không được để trống.'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'tooShort' => 'Mật khẩu phải có ít nhất ' . Yii::$app->params['user.passwordMinLength'] . ' ký tự.'],

            // Quy tắc cho full_name
            ['full_name', 'required', 'message' => 'Họ và tên không được để trống.'],
            ['full_name', 'string', 'max' => 255, 'tooLong' => 'Họ và tên không được vượt quá 255 ký tự.'],

            // Quy tắc cho phone
            ['phone', 'string', 'max' => 20, 'tooLong' => 'Số điện thoại không được vượt quá 20 ký tự.'],
            ['phone', 'match', 'pattern' => '/^[0-9\s\-\+\(\)]+$/', 'message' => 'Số điện thoại không hợp lệ.'], // Basic phone number validation

            // Quy tắc cho job_title_id và department_id
            [['job_title_id', 'department_id'], 'integer', 'message' => '{attribute} phải là số nguyên.'],
            // Optional: Add exist validators if you want to ensure they refer to existing records
            // [['job_title_id'], 'exist', 'skipOnError' => true, 'targetClass' => JobTitle::class, 'targetAttribute' => ['job_title_id' => 'job_title_id']],
            // [['department_id'], 'exist', 'skipOnError' => true, 'targetClass' => Department::class, 'targetAttribute' => ['department_id' => 'department_id']],

            // Quy tắc cho status (đã có giá trị mặc định)
            ['status', 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Mã Nhân Viên',
            'email' => 'Email',
            'password' => 'Mật khẩu',
            'full_name' => 'Họ và tên',
            'phone' => 'Số điện thoại',
            'job_title_id' => 'Chức vụ',
            'department_id' => 'Phòng ban',
            'status' => 'Trạng thái',
        ];
    }

    /**
     * Đăng ký người dùng mới.
     *
     * @return bool liệu việc tạo tài khoản mới có thành công và email đã được gửi hay không
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
        $user->generateEmailVerificationToken();
        
        $user->full_name = $this->full_name;
        $user->phone = $this->phone;
        $user->job_title_id = $this->job_title_id;
        $user->department_id = $this->department_id;
        $user->status = $this->status;

        $user->created_at = time();
        $user->updated_at = time();

        return $user->save();
    }

    /**
     * Gửi email xác nhận cho người dùng
     * @param User $user model người dùng để gửi email
     * @return bool liệu email đã được gửi hay không
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Đăng ký tài khoản tại ' . Yii::$app->name)
            ->send();
    }
}

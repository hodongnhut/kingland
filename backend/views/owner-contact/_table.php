<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Vai Trò</th>
            <th>Tên Liên Hệ</th>
            <th>Số Điện Thoại</th>
            <th>Giới Tính</th>
            <?php if (in_array(Yii::$app->user->identity->jobTitle->role_code ?? '', ['manager', 'super_admin'])): ?>
                <th>Hành động</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td><?= Html::encode($contact->role ? $contact->role->name : 'Không xác định') ?></td>
                <td><?= Html::encode($contact->contact_name) ?></td>
                <td>
                    <?php
                        $phone = $contact->phone_number;
                        echo strlen($phone) >= 3 ? '•••••••' . substr($phone, -3) : '***';
                    ?>
                </td>
                <td><?= Html::encode($contact->gender ? $contact->gender->name : 'Không xác định') ?></td>
                <?php if (in_array(Yii::$app->user->identity->jobTitle->role_code ?? '', ['manager', 'super_admin'])): ?>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-primary btn-update-contact" data-id="<?= $contact->contact_id ?>" data-url="<?= Url::to(['/owner-contact/get-contact', 'id' => $contact->contact_id]) ?>"><i class="fas fa-pencil-alt"></i></a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

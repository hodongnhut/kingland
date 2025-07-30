<?php use yii\helpers\Html; ?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Vai Trò</th>
            <th>Tên Liên Hệ</th>
            <th>Số Điện Thoại</th>
            <th>Giới Tính</th>
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
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

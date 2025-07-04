<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "attachments".
 *
 * @property int $attachment_id
 * @property int $post_id
 * @property string $file_name
 * @property string $file_path
 * @property string|null $file_type
 * @property int|null $file_size
 * @property string $uploaded_at
 *
 * @property Posts $post
 */
class Attachments extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $file; 

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attachments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_type', 'file_size'], 'default', 'value' => null],
            [['post_id', 'file_name', 'file_path'], 'required'],
            [['post_id', 'file_size'], 'integer'],
            [['uploaded_at'], 'safe'],
            [['file_name', 'file_path'], 'string', 'max' => 255],
            [['file_type'], 'string', 'max' => 50],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::class, 'targetAttribute' => ['post_id' => 'post_id']],
            [['file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif, pdf, doc, docx, xls, xlsx', 'maxFiles' => 10, 'maxSize' => 1024 * 1024 * 5],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'attachment_id' => 'Attachment ID',
            'post_id' => 'Post ID',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'uploaded_at' => 'Uploaded At',
            'file' => 'Tệp đính kèm',
        ];
    }

    /**
     * Gets query for [[Post]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::class, ['post_id' => 'post_id']);
    }

    /**
     * Uploads the file and saves attachment metadata.
     * @param int $post_id The ID of the post this attachment belongs to.
     * @return bool Whether the file was uploaded and saved successfully.
     */
    public function upload($post_id)
    {
        if ($this->validate()) {
            $this->post_id = $post_id;

            // Define upload directory (make sure this directory exists and is writable)
            $uploadPath = Yii::getAlias('@frontend/web/uploads/attachments'); // For frontend access
            // Or for backend uploads, if this is a backend operation:
            // $uploadPath = Yii::getAlias('@backend/web/uploads/attachments');

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true); // Create directory recursively if it doesn't exist
            }

            // Generate unique file name to prevent overwrites
            $fileName = uniqid() . '.' . $this->file->extension;
            $filePath = $uploadPath . '/' . $fileName;

            if ($this->file->saveAs($filePath)) {
                $this->file_name = $this->file->baseName . '.' . $this->file->extension;
                $this->file_path = '/uploads/attachments/' . $fileName; // Path relative to web root
                $this->file_type = $this->file->type;
                $this->file_size = $this->file->size;
                $this->uploaded_at = date('Y-m-d H:i:s'); // Set current timestamp

                return $this->save(false); // Save attachment record to database (skip validation as it's already done)
            }
        }
        return false;
    }

}

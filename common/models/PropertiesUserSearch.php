<?php
namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PropertiesUserSearch extends Properties
{
    public $start_date;
    public $end_date;
    public $username;

    public function rules()
    {
        return [
            [['start_date', 'end_date', 'username'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = User::find()
            ->select(['user.id', 'user.username', 'user.email', 'COUNT(properties.property_id) as property_count'])
            ->leftJoin('properties', 'properties.user_id = user.id')
            ->groupBy('user.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Lọc theo khoảng thời gian
        if ($this->start_date) {
            $query->andWhere(['>=', 'properties.created_at', $this->start_date]);
        }
        if ($this->end_date) {
            $query->andWhere(['<=', 'properties.created_at', $this->end_date . ' 23:59:59']);
        }

        if ($this->username) {
            $query->andWhere(['like', 'user.username', $this->username]);
        }

        return $dataProvider;
    }
}
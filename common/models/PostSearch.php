<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Posts;

/**
 * PostSearch represents the model behind the search form of `common\models\Posts`.
 */
class PostSearch extends Posts
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'category_id', 'is_active'], 'integer'],
            [['post_title', 'post_content', 'post_type', 'post_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = Posts::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [ // Add this sort configuration
                'defaultOrder' => [
                    'post_id' => SORT_DESC, // Sort by post_id in descending order
                ]
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'post_id' => $this->post_id,
            'category_id' => $this->category_id,
            'post_date' => $this->post_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'post_title', $this->post_title])
            ->andFilterWhere(['like', 'post_content', $this->post_content])
            ->andFilterWhere(['like', 'post_type', $this->post_type]);

        return $dataProvider;
    }
}

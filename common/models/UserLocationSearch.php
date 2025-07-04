<?php

namespace common\models;

use Yii; // Import Yii to access current user
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserLocations;

/**
 * UserLocationSearch represents the model behind the search form of `common\models\UserLocations`.
 */
class UserLocationSearch extends UserLocations
{
    // Add a public property for searching by username
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['device_type', 'os', 'browser', 'device_unique_id', 'session_id', 'created_at', 'username'], 'safe'], // Add 'username' to safe attributes
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
        $query = UserLocations::find();

        // Add a join with the User table to enable filtering by username
        // Assuming your UserLocations model has a 'user_id' which relates to 'id' in your User model
        $query->joinWith(['user']); // Assuming 'user' is the name of the relation in UserLocations model

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [ // Optional: default sort, e.g., by creation date descending
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // --- Role-based Filtering Logic ---
        $currentUser = Yii::$app->user->identity;
        $isSuperAdminOrManager = false;

        // Check if the user is logged in and has the necessary role code
        if ($currentUser && isset($currentUser->jobTitle) && isset($currentUser->jobTitle->role_code)) {
            $roleCode = $currentUser->jobTitle->role_code;
            if ($roleCode === 'super_admin' || $roleCode === 'manager') {
                $isSuperAdminOrManager = true;
            }
        }

        if (!$isSuperAdminOrManager) {
            // If not super_admin or manager, restrict to their own user_id
            $query->andFilterWhere([
                'user_id' => Yii::$app->user->id,
            ]);
        }
        // --- End Role-based Filtering Logic ---


        // grid filtering conditions (apply after role-based filtering)
        $query->andFilterWhere([
            'user_locations.id' => $this->id, // Use table alias for clarity
            'user_locations.user_id' => $this->user_id, // Use table alias for clarity
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'user_locations.created_at' => $this->created_at, // Use table alias for clarity
        ]);

        $query->andFilterWhere(['like', 'device_type', $this->device_type])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'device_unique_id', $this->device_unique_id])
            ->andFilterWhere(['like', 'session_id', $this->session_id])
            ->andFilterWhere(['like', 'user.username', $this->username]); // Filter by username

        return $dataProvider;
    }
}
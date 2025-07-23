<?php
namespace common\helpers;

use common\models\PropertyFavorite;
use yii\httpclient\Client;
use Yii;

class FavoriteHelper
{
    /**
     * Checks if a property is favorited by a given user.
     * If userId is null, it defaults to the currently logged-in user.
     * @param int $propertyId The ID of the property.
     * @param int|null $userId The ID of the user. If null, uses Yii::$app->user->id.
     * @return bool True if favorited, false otherwise.
     */
    public static function isPropertyFavorited($propertyId, $userId = null)
    {
        if ($userId === null) {
            if (Yii::$app->user->isGuest) {
                return false; // Not logged in, cannot be favorited
            }
            $userId = Yii::$app->user->id;
        }

        return PropertyFavorite::find()
            ->where(['user_id' => $userId, 'property_id' => $propertyId])
            ->exists();
    }
}
<?php

namespace backend\controllers\api;

use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use common\models\Properties;
use common\models\PropertiesSearch;

class PropertyController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function actionIndex()
    {
        // Check if user is authenticated
        if (Yii::$app->user->isGuest) {
            return $this->response(false, 'Unauthorized');
        }

        $searchModel = new PropertiesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if (!$searchModel->validate()) {
            return $this->response(false, 'Invalid search parameters', ['errors' => $searchModel->getErrors()]);
        }


        $properties = $dataProvider->getModels();


        $imageDomain = Yii::$app->params['imageDomain'] ?? 'https://kinglandgroup.vn';

        $noImage = [
            'image_path'=> 'https://kinglandgroup.vn/no-image.webp'
        ];

        $data = [];
        foreach ($properties as $property) {
            $images = [];
            foreach ($property->propertyImages as $image) {
                $images[] = [
                    'image_id' => $image->image_id,
                    'image_path' => rtrim($imageDomain, '/') . '/' . ltrim($image->image_path, '/'),
                    'is_main' => $image->is_main,
                    'sort_order' => $image->sort_order,
                ];
            }

            $contacts = [];
            foreach ($property->ownerContacts as $contact) {
                $contacts[] = [
                    'contact_id' => $contact->contact_id,
                    'contact_name' => $contact->contact_name,
                    'phone_number' => $contact->phone_number,
                    'role' => $contact->role ? $contact->role->name : null,
                    'gender' => $contact->gender ? $contact->gender->name : null,
                ];
            }

            $data[] = [
                'property_id' => $property->property_id,
                'title' => $property->title,
                'listing' =>$property->listingType->name,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'location_type' => $property->locationType ? $property->locationType->type_name : null,
                'price' => $property->price,
                'final_price' => $property->final_price,
                'area_total' => $property->area_total,
                'area_length' => $property->area_length,
                'area_width' => $property->area_width,
                'street_name' => $property->street_name,
                'ward_commune' => $property->ward_commune,
                'district_county' => $property->district_county,
                'city' => $property->city,
                'created_at' => $property->created_at,
                'updated_at' => $property->updated_at,
                'transaction_status' => $property->transactionStatus ? $property->transactionStatus->status_name : null,
                'property_type' => $property->propertyType ? $property->propertyType->type_name : null,
                'direction' => $property->direction ? $property->direction->name : null,
                'asset_type' => $property->assetType ? $property->assetType->type_name : null,
                'images' => count($images) > 0 ? $images : $noImage,
                'owner_contacts' => $contacts,
                'red_book' => $property->getRedbook()
            ];
        }

        // Pagination info
        $pagination = $dataProvider->getPagination();

        return $this->response(true, empty($data) ? 'No properties found' : 'Properties retrieved successfully', [
            'properties' => $data,
            'pagination' => [
                'total' => $pagination->totalCount,
                'page' => $pagination->getPage() + 1, // 1-based page number
                'pageSize' => $pagination->pageSize,
                'totalPages' => $pagination->pageCount,
            ],
        ]);
    }

    private function response($status, $msg, $data = null)
    {
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }
}
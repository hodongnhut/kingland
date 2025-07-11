<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rental_contracts".
 *
 * @property int $contract_id ID tự tăng, khóa chính
 * @property int $property_id Khóa ngoại, liên kết đến BĐS tương ứng
 * @property float|null $rent_price Giá cho thuê mỗi kỳ
 * @property int|null $currency_id FK đến bảng currencies
 * @property int|null $lease_term Thời gian thuê (ví dụ: 5, 10)
 * @property string|null $lease_term_unit Đơn vị thời gian thuê (tháng, năm)
 * @property string|null $price_time_unit Kỳ hạn của giá thuê (giá/tháng, giá/năm)
 * @property string|null $expiry_date Ngày hết hạn hợp đồng
 *
 * @property Currencies $currency
 * @property Properties $property
 */
class RentalContracts extends \yii\db\ActiveRecord
{

    /**
     * ENUM field values
     */
    const LEASE_TERM_UNIT_MONTH = 'month';
    const LEASE_TERM_UNIT_YEAR = 'year';
    const PRICE_TIME_UNIT_PER_MONTH = 'per_month';
    const PRICE_TIME_UNIT_PER_YEAR = 'per_year';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rental_contracts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rent_price', 'lease_term', 'lease_term_unit', 'price_time_unit', 'expiry_date'], 'default', 'value' => null],
            [['currency_id'], 'default', 'value' => 1],
            [['property_id'], 'required'],
            [['property_id', 'currency_id', 'lease_term'], 'integer'],
            [['rent_price'], 'number'],
            [['lease_term_unit', 'price_time_unit'], 'string'],
            [['expiry_date'], 'safe'],
            ['lease_term_unit', 'in', 'range' => array_keys(self::optsLeaseTermUnit())],
            ['price_time_unit', 'in', 'range' => array_keys(self::optsPriceTimeUnit())],
            [['property_id'], 'unique'],
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currencies::class, 'targetAttribute' => ['currency_id' => 'id']],
            [['property_id'], 'exist', 'skipOnError' => true, 'targetClass' => Properties::class, 'targetAttribute' => ['property_id' => 'property_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'contract_id' => 'Contract ID',
            'property_id' => 'Property ID',
            'rent_price' => 'Rent Price',
            'currency_id' => 'Currency ID',
            'lease_term' => 'Lease Term',
            'lease_term_unit' => 'Lease Term Unit',
            'price_time_unit' => 'Price Time Unit',
            'expiry_date' => 'Expiry Date',
        ];
    }

    /**
     * Gets query for [[Currency]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currencies::class, ['id' => 'currency_id']);
    }

    /**
     * Gets query for [[Property]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProperty()
    {
        return $this->hasOne(Properties::class, ['property_id' => 'property_id']);
    }


    /**
     * column lease_term_unit ENUM value labels
     * @return string[]
     */
    public static function optsLeaseTermUnit()
    {
        return [
            self::LEASE_TERM_UNIT_MONTH => 'month',
            self::LEASE_TERM_UNIT_YEAR => 'year',
        ];
    }

    /**
     * column price_time_unit ENUM value labels
     * @return string[]
     */
    public static function optsPriceTimeUnit()
    {
        return [
            self::PRICE_TIME_UNIT_PER_MONTH => 'per_month',
            self::PRICE_TIME_UNIT_PER_YEAR => 'per_year',
        ];
    }

    /**
     * @return string
     */
    public function displayLeaseTermUnit()
    {
        return self::optsLeaseTermUnit()[$this->lease_term_unit];
    }

    /**
     * @return bool
     */
    public function isLeaseTermUnitMonth()
    {
        return $this->lease_term_unit === self::LEASE_TERM_UNIT_MONTH;
    }

    public function setLeaseTermUnitToMonth()
    {
        $this->lease_term_unit = self::LEASE_TERM_UNIT_MONTH;
    }

    /**
     * @return bool
     */
    public function isLeaseTermUnitYear()
    {
        return $this->lease_term_unit === self::LEASE_TERM_UNIT_YEAR;
    }

    public function setLeaseTermUnitToYear()
    {
        $this->lease_term_unit = self::LEASE_TERM_UNIT_YEAR;
    }

    /**
     * @return string
     */
    public function displayPriceTimeUnit()
    {
        return self::optsPriceTimeUnit()[$this->price_time_unit];
    }

    /**
     * @return bool
     */
    public function isPriceTimeUnitPermonth()
    {
        return $this->price_time_unit === self::PRICE_TIME_UNIT_PER_MONTH;
    }

    public function setPriceTimeUnitToPermonth()
    {
        $this->price_time_unit = self::PRICE_TIME_UNIT_PER_MONTH;
    }

    /**
     * @return bool
     */
    public function isPriceTimeUnitPeryear()
    {
        return $this->price_time_unit === self::PRICE_TIME_UNIT_PER_YEAR;
    }

    public function setPriceTimeUnitToPeryear()
    {
        $this->price_time_unit = self::PRICE_TIME_UNIT_PER_YEAR;
    }
}

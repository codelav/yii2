<?php
declare(strict_types=1);

namespace app\modules\history\entity;

use app\models\Call;
use app\models\Customer;
use app\models\Fax;
use app\models\Sms;
use app\models\Task;
use app\models\User;
use stdClass;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%history}}".
 *
 * @property integer $id
 * @property string $ins_ts
 * @property integer $customer_id
 * @property string $event
 * @property string $object
 * @property integer $object_id
 * @property string $message
 * @property string $detail
 * @property integer $user_id
 *
 * @property string $eventText
 *
 * @property Customer $customer
 * @property User $user
 */
class History extends ActiveRecord
{
    public const OBJECT_NAME_ENTITY_CLASS_MAP = [
        'customer' => Customer::class,
        'task' => Task::class,
        'sms' => Sms::class,
        'call' => Call::class,
        'fax' => Fax::class,
    ];

    public const EVENT_CREATED_TASK = 'created_task';
    public const EVENT_UPDATED_TASK = 'updated_task';
    public const EVENT_COMPLETED_TASK = 'completed_task';
    public const EVENT_INCOMING_SMS = 'incoming_sms';
    public const EVENT_OUTGOING_SMS = 'outgoing_sms';
    public const EVENT_INCOMING_CALL = 'incoming_call';
    public const EVENT_OUTGOING_CALL = 'outgoing_call';
    public const EVENT_INCOMING_FAX = 'incoming_fax';
    public const EVENT_OUTGOING_FAX = 'outgoing_fax';
    public const EVENT_CUSTOMER_CHANGE_TYPE = 'customer_change_type';
    public const EVENT_CUSTOMER_CHANGE_QUALITY = 'customer_change_quality';
    public static function tableName(): string
    {
        return '{{%history}}';
    }

    public function rules(): array
    {
        return [
            [['ins_ts'], 'safe'],
            [['customer_id', 'object_id', 'user_id'], 'integer'],
            [['event'], 'required'],
            [['message', 'detail'], 'string'],
            [['event', 'object'], 'string', 'max' => 255],
            [
                ['customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Customer::class,
                'targetAttribute' => ['customer_id' => 'id'],
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::class,
                'targetAttribute' => ['user_id' => 'id'],
            ],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ins_ts' => Yii::t('app', 'Ins Ts'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'event' => Yii::t('app', 'Event'),
            'object' => Yii::t('app', 'Object'),
            'object_id' => Yii::t('app', 'Object ID'),
            'message' => Yii::t('app', 'Message'),
            'detail' => Yii::t('app', 'Detail'),
            'user_id' => Yii::t('app', 'User ID'),
        ];
    }

    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getRelation($name, $throwException = true)
    {
        if (isset(self::OBJECT_NAME_ENTITY_CLASS_MAP[$name])) {
            return $this->hasOne(self::OBJECT_NAME_ENTITY_CLASS_MAP[$name], ['id' => 'object_id']);
        }

        return parent::getRelation($name, $throwException);
    }

    public function getRelatedObject(string $name): ?ActiveRecord
    {
        if (!array_key_exists($name, self::OBJECT_NAME_ENTITY_CLASS_MAP)) {
            return null;
        }

        return $this->{$name};
    }

    public function getEventText(): string
    {
        $eventTexts = [
            self::EVENT_CREATED_TASK => Yii::t('app', 'Task created'),
            self::EVENT_UPDATED_TASK => Yii::t('app', 'Task updated'),
            self::EVENT_COMPLETED_TASK => Yii::t('app', 'Task completed'),

            self::EVENT_INCOMING_SMS => Yii::t('app', 'Incoming message'),
            self::EVENT_OUTGOING_SMS => Yii::t('app', 'Outgoing message'),

            self::EVENT_CUSTOMER_CHANGE_TYPE => Yii::t('app', 'Type changed'),
            self::EVENT_CUSTOMER_CHANGE_QUALITY => Yii::t('app', 'Property changed'),

            self::EVENT_OUTGOING_CALL => Yii::t('app', 'Outgoing call'),
            self::EVENT_INCOMING_CALL => Yii::t('app', 'Incoming call'),

            self::EVENT_INCOMING_FAX => Yii::t('app', 'Incoming fax'),
            self::EVENT_OUTGOING_FAX => Yii::t('app', 'Outgoing fax'),
        ];

        return $eventTexts[$this->event] ?? '';
    }

    public function getDetailChangedAttribute(string $attribute): ?stdClass
    {
        $detail = json_decode($this->detail, false);

        return $detail->changedAttributes->{$attribute} ?? null;
    }

    public function getDetailOldValue(string $attribute): ?string
    {
        $detail = $this->getDetailChangedAttribute($attribute);

        return $detail->old ?? null;
    }

    public function getDetailNewValue(string $attribute): ?string
    {
        $detail = $this->getDetailChangedAttribute($attribute);

        return $detail->new ?? null;
    }
}

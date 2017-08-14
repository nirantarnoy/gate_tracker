<?php
namespace backend\models;

use backend\models\Journal;
use yii\db\ActiveRecord;

date_default_timezone_set('Asia/Bangkok');
class Journal extends \common\models\Journal
{
  public function behaviors()
{
    return [
        'timestampcdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'created_at',
            ],
            'value'=> time(),
        ],
        'timestampudate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_INSERT=>'updated_at',
            ],
          'value'=> time(),
        ],
        'timestampupdate'=>[
            'class'=> \yii\behaviors\AttributeBehavior::className(),
            'attributes'=>[
            ActiveRecord::EVENT_BEFORE_UPDATE=>'updated_at',
            ],
            'value'=> time(),
        ],
    ];
 }
 public static function getLastNo(){
    $model = Journal::find()->MAX('journal_no');
    if($model){
      $prefix ="TR";
      $cnum = substr((string)$model,2,strlen($model));
      $len = strlen($cnum);
      $clen = strlen($cnum + 1);
      $loop = $len - $clen;
      for($i=1;$i<=$loop;$i++){
        $prefix.="0";
      }
      $prefix.=$cnum + 1;
      return $prefix;
    }else{
        $prefix ="TR".substr(date('Y'),2,2);
        return $prefix.'000001';
    }
}
  public function getContacttype(){
    return $this->hasOne(\backend\models\Contacttype::className(),['id'=>'activity_id']);
  }
  public function getCartype(){
    return $this->hasOne(\backend\models\Cartype::className(),['id'=>'car_type']);
  }
}

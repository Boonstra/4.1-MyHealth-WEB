<?php

/**
 * This is the model class for table "tbl_user".
 *
 * The followings are the available columns in table 'tbl_user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $first_login
 * @property string $language
 * @property integer $wrong_logins
 * @property string $last_login
 * @property integer $practitioner_id
 * @property string $bsn
 *
 * The followings are the available model relations:
 * @property Bill[] $bills
 * @property FailedLogins[] $failedLogins
 * @property Practitioner $practitioner
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, email, first_login, language, wrong_logins, last_login, role, practitioner_id, bsn', 'required'),
			array('first_login, wrong_logins, role, practitioner_id', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>32),
			array('password', 'length', 'max'=>512),
			array('email', 'length', 'max'=>64),
			array('language', 'length', 'max'=>12),
			array('bsn', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, email, first_login, language, wrong_logins, last_login, role, practitioner_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'bills' => array(self::HAS_MANY, 'Bill', 'user_id'),
			'failedLogins' => array(self::HAS_MANY, 'FailedLogins', 'user_id'),
			'practitioner' => array(self::BELONGS_TO, 'Practitioner', 'practitioner_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'email' => 'Email',
			'first_login' => 'First Login',
			'language' => 'Language',
			'wrong_logins' => 'Wrong Logins',
			'last_login' => 'Last Login',
			'practitioner_id' => 'Practitioner',
			'bsn' => 'Burger service nummer',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('first_login',$this->first_login);
		$criteria->compare('language',$this->language,true);
		$criteria->compare('wrong_logins',$this->wrong_logins);
		$criteria->compare('last_login',$this->last_login,true);
		$criteria->compare('practitioner_id',$this->practitioner_id);
		$criteria->compare('bsn',$this->bsn);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}

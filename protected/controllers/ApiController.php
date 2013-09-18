<?php

class ApiController extends Controller
{
	// Members
	/**
	 * Key which has to be in HTTP USERNAME and PASSWORD headers
	 */
	Const APPLICATION_ID = 'ASCCPE';

	/**
	 * Default response format
	 * either 'json' or 'xml'
	 */
	private $format = 'json';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array();
	}

	// Actions
	public function actionList()
	{
		// Get the respective model instance
		switch($_GET['model'])
		{
			case 'posts':
				$models = Post::model()->findAll();
				break;
			default:
				$this->_sendResponse(200, json_encode(array('message' => 'failed')));

			Yii::app()->end();

//				// Model not implemented error
//				$this->_sendResponse(501, sprintf(
//					'Error: Mode <b>list</b> is not implemented for model <b>%s</b>',
//					$_GET['model']) );
//				Yii::app()->end();
		}
//		// Did we get some results?
//		if(empty($models)) {
//			// No
//			$this->_sendResponse(200,
//				sprintf('No items where found for model <b>%s</b>', $_GET['model']) );
//		} else {
//			// Prepare response
//			$rows = array();
//			foreach($models as $model)
//				$rows[] = $model->attributes;
//			// Send the response
//			$this->_sendResponse(200, CJSON::encode($rows));
//		}
	}

	public function actionView()
	{

	}

	public function actionCreate()
	{

	}

	public function actionUpdate()
	{

	}

	public function actionDelete()
	{

	}
}

<?php

class TestController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
//		return array(
//			'accessControl', // perform access control for CRUD operations
//			array(
//				'ext.starship.RestfullYii.filters.ERestFilter +
//				REST.GET, REST.PUT, REST.POST, REST.DELETE'
//			),
//		);

//		GET Request: Filtering results (WorkController)
//
//		You can filter your results by any valid param or multiple params as well as an operator.
//
//			Available filter operators:
//
//		in
//		not in
//				=
//		!=
//		>
//		>=
//		<
//		<=
//		No operator is "LIKE"
//			/api/post/?filter = [
//		  {"property": "id", "value" : 50, "operator": ">="}
//		, {"property": "user_id", "value" : [1, 5, 10, 14], "operator": "in"}
//		, {"property": "state", "value" : ["save", "deleted"], "operator": "not in"}
//		, {"property": "date", "value" : "2013-01-01", "operator": ">="}
//		, {"property": "date", "value" : "2013-01-31", "operator": "<="}
//		, {"property": "type", "value" : 2, "operator": "!="}
//		]
	}

	/**
	 * @return array actions
	 */
	public function actions()
	{
//		return array(
//			'REST.'=>'ext.starship.RestfullYii.actions.ERestActionProvider',
//		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
//		return array(
////			array('allow',  // allow all users to perform 'index' and 'view' actions
////				'actions'=>array('index','view'),
////				'users'=>array('*'),
////			),
////			array('allow', // allow authenticated user to perform 'create' and 'update' actions
////				'actions'=>array('create','update'),
////				'users'=>array('@'),
////			),
////			array('allow', // allow admin user to perform 'admin' and 'delete' actions
////				'actions'=>array('admin','delete'),
////				'users'=>array('admin'),
////			),
//
//			array('allow', 'actions'=>array('REST.GET', 'REST.PUT', 'REST.POST', 'REST.DELETE'),
//				'users'=>array('*'),
//			),
//
//			array('allow',  // allow all users
//				'users'=>array('*'),
//			),
//		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

	}
}

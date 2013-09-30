<?php
/**
 * ApiController class file
 * @author Joachim Werner <joachim.werner@diggin-data.de>
 */
/**
 * ApiController
 *
 * @uses Controller
 * @author Joachim Werner <joachim.werner@diggin-data.de>
 * @author
 * @see http://www.gen-x-design.com/archives/making-restful-requests-in-php/
 * @license (tbd)
 */
class ApiController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array();
	}

	/**
	 * Checks authorization. Returns success and the user model upon success.
	 */
	public function actionLogin()
	{
		$user = $this->_checkUserAuthentication();

		$this->_sendResponse(200, CJSON::encode(array('message' => 'success', 'user' => $user->attributes)));
	}

	/**
	 * Encrypts the password that is sent through the $_GET variable.
	 */
	public function actionGetEncryptedPassword()
	{
		$password = "";

		if (isset($_GET['password']))
		{
			$password = $_GET['password'];
		}

		$this->_sendResponse(200, CPasswordHelper::hashPassword($password));
	}

	/**
	 * Lists all implemented objects within the given datetime range.
	 *
	 * A limit and offset can be set.
	 */
	public function actionList()
	{
		$user = $this->_checkUserAuthentication();

		$criteria = new CDbCriteria();

		$criteria->addCondition('user_id = ' . $user->id);

		if (isset($_REQUEST['offset']) &&
			is_numeric($_REQUEST['offset']) &&
			$_REQUEST['offset'] >= 0)
		{
			$criteria->offset = $_REQUEST['userID'];
		}

		if (isset($_REQUEST['limit']) &&
			is_numeric($_REQUEST['limit']) &&
			$_REQUEST['limit'] >= 0)
		{
			$criteria->limit = $_REQUEST['userID'];
		}

		$dateFrom = $dateTo = "";

		if (isset($_REQUEST['dateFrom']) &&
			strlen($_REQUEST['dateFrom']) > 0)
		{
			$dateFrom = $_REQUEST['dateFrom'];
		}

		if (isset($_REQUEST['dateTo']) &&
			strlen($_REQUEST['dateTo']) > 0)
		{
			$dateTo = $_REQUEST['dateTo'];
		}

		if (!empty($dateFrom) &&
			!empty($dateTo))
		{
			$criteria->addBetweenCondition('datetime', $dateFrom, $dateTo);
		}
		else if (!empty($dateFrom))
		{
			$criteria->addBetweenCondition('datetime', $dateFrom, date('Y-m-d h:i:s'));
		}
		else if (!empty($dateTo))
		{
			$criteria->addBetweenCondition('datetime', '1900-01-01 00:00:00', $dateTo);
		}

		switch($_GET['model'])
		{
			case 'bloodPressureMeasurement':
				$models = BloodPressureMeasurement::model()->findAll($criteria);
				break;

			case 'pulseMeasurement':
				$models = PulseMeasurement::model()->findAll($criteria);
				break;

			case 'ECGMeasurement':
				$models = ECGMeasurement::model()->findAll($criteria);
				break;

			default:
				$this->_sendResponse(501, CJSON::encode(array("message" => "failed", "error" => "The list action is not implemented for this model")));
				Yii::app()->end();
		}

		$rows = array();

		if (count($models) > 0)
		{
			foreach ($models as $model)
			{
				$rows[] = $model->attributes;
			}
		}

		$this->_sendResponse(200, CJSON::encode(array("message" => "success", "measurements" => $rows)));
	}

	/* Shows a single item
	 *
	 * @access public
	 * @return void
	 */
	public function actionView()
	{
		$this->_sendResponse(501, CJSON::encode(array("message" => "failed", "error" => "Not implemented yet")));
	}

	/**
	 * Creates a new item
	 *
	 * @access public
	 * @return void
	 */
	public function actionCreate()
	{
		$user = $this->_checkUserAuthentication();

		$_GET['user_id'] = $user->id;

		switch($_GET['model'])
		{
			case 'bloodPressureMeasurement':
				$model = new BloodPressureMeasurement();
				break;

			case 'pulseMeasurement':
				$model = new PulseMeasurement();
				break;

			case 'ECGMeasurement':
				$model = new ECGMeasurement();
				break;

			default:
				$this->_sendResponse(501, CJSON::encode(array("message" => "failed", "error" => "The create action is not implemented for this model")));
				Yii::app()->end();
		}

		// Loop through get variables
		foreach ($_GET as $variableName => $value)
		{
			// Check if the model has this variable
			if ($model->hasAttribute($variableName))
			{
				$model->$variableName = $value;
			}
		}

		// Return if successfully saved
		if($model->save())
		{
			$this->_sendResponse(200, CJSON::encode(array("message" => "success", "measurement" => $model->attributes)));

			Yii::app()->end();
		}

		$errorMessage = "";

		foreach ($model->errors as $attribute => $attributeErrors)
		{
			$errorMessage .= $attribute . ": ";

			foreach ($attributeErrors as $attributeError)
			{
				$errorMessage .= $attributeError . ", ";
			}

			$errorMessage .= " - ";
		}

		$this->_sendResponse(500, CJSON::encode(array("message" => "failed", "error" => $errorMessage)));
	}

	/**
	 * Update a single item
	 *
	 * @access public
	 * @return void
	 */
	public function actionUpdate()
	{
		$this->_sendResponse(501, CJSON::encode(array("message" => "failed", "error" => "Not implemented yet")));
	}

	/**
	 * Deletes a single item
	 *
	 * @access public
	 * @return void
	 */
	public function actionDelete()
	{
		$this->_checkUserAuthentication();

		if (isset($_GET['id']) &&
			is_numeric($_GET['id']) &&
			$_GET['id'] >= 0)
		{
			$ID = $_GET['id'];
		}
		else
		{
			$this->_sendResponse(500, CJSON::encode(array("message" => "failed", "error" => "No ID was provided")));
		}

		$model = null;

		switch($_GET['model'])
		{
			case 'bloodPressureMeasurement':
				$model = BloodPressureMeasurement::model()->findByPk($ID);
				break;

			case 'pulseMeasurement':
				$model = PulseMeasurement::model()->findByPk($ID);
				break;

			case 'ECGMeasurement':
				$model = ECGMeasurement::model()->findByPk($ID);
				break;

			default:
				$this->_sendResponse(501, CJSON::encode(array("message" => "failed", "error" => "The delete action is not implemented for this model")));
				Yii::app()->end();
		}

		if (!is_null($model) &&
			$model->delete())
		{
			$this->_sendResponse(200, CJSON::encode(array("message" => "success")));
		}
		else
		{
			$this->_sendResponse(500, CJSON::encode(array("message" => "failed", "error" => "No model with the provided ID could be found")));
		}
	}

	/**
	 * Sends the API response
	 *
	 * @param int $status
	 * @param string $body
	 * @param string $content_type
	 * @access private
	 * @return void
	 */
	private function _sendResponse($status = 200, $body = '', $content_type = 'text/html')
	{
		$status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
		// set the status
		header($status_header);
		// set the content type
		header('Content-type: ' . $content_type);

		// pages with body are easy
		if($body != '')
		{
			// send the body
			echo $body;
			exit;
		}
		// we need to create the body if none is passed
		else
		{
			// create some body messages
			$message = '';

			// this is purely optional, but makes the pages a little nicer to read
			// for your users.  Since you won't likely send a lot of different status codes,
			// this also shouldn't be too ponderous to maintain
			switch($status)
			{
				case 401:
					$message = 'You must be authorized to view this page.';
					break;
				case 404:
					$message = 'The requested URL ' . $_SERVER['REQUEST_URI'] . ' was not found.';
					break;
				case 500:
					$message = 'The server encountered an error processing your request.';
					break;
				case 501:
					$message = 'The requested method is not implemented.';
					break;
			}

			// servers don't always have a signature turned on (this is an apache directive "ServerSignature On")
			$signature = ($_SERVER['SERVER_SIGNATURE'] == '') ? $_SERVER['SERVER_SOFTWARE'] . ' Server at ' . $_SERVER['SERVER_NAME'] . ' Port ' . $_SERVER['SERVER_PORT'] : $_SERVER['SERVER_SIGNATURE'];

			// this should be templatized in a real-world solution
			$body = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
                        <html>
                            <head>
                                <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
                                <title>' . $status . ' ' . $this->_getStatusCodeMessage($status) . '</title>
                            </head>
                            <body>
                                <h1>' . $this->_getStatusCodeMessage($status) . '</h1>
                                <p>' . $message . '</p>
                                <hr />
                                <address>' . $signature . '</address>
                            </body>
                        </html>';

			echo $body;
			exit;
		}
	}

	/**
	 * Gets the message for a status code
	 *
	 * @param mixed $status
	 * @access private
	 * @return string
	 */
	private function _getStatusCodeMessage($status)
	{
		// these could be stored in a .ini file and loaded
		// via parse_ini_file()... however, this will suffice
		// for an example
		$codes = Array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			306 => '(Unused)',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported'
		);

		return (isset($codes[$status])) ? $codes[$status] : '';
	}

	/**
	 * @return UserIdentity $user
	 */
	private function _getUserIdentityFromRequest()
	{
		$username = $password = "";

		if (isset($_REQUEST['username']) &&
			strlen($_REQUEST['username']) > 0)
		{
			$username = $_REQUEST['username'];
		}

		if (isset($_REQUEST['password']) &&
			strlen($_REQUEST['password']) > 0)
		{
			$password = $_REQUEST['password'];
		}

		$userIdentity = new UserIdentity($username, $password);

		return $userIdentity;
	}

	/**
	 * This method takes a username and password (or gets them from $_REQUEST when empty) to check whether or not they
	 * match with a User record from the database.
	 *
	 * Returns an array with as fist value an integer indicating whether the user is 0: Valid, 1: Invalid, or 2: Blocked.
	 * The second value in the returned array is the User model instance.
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return array [int 0 | 1 | 2, User user]
	 */
	private function _getUserAuthentication($username = "", $password = "")
	{
		if (strlen($username) <= 0 &&
			isset($_REQUEST['username']) &&
			strlen($_REQUEST['username']) > 0)
		{
			$username = $_REQUEST['username'];
		}
		else
		{
			return false;
		}

		if (strlen($password) <= 0 &&
			isset($_REQUEST['password']) &&
			strlen($_REQUEST['password']) > 0)
		{
			$password = $_REQUEST['password'];
		}
		else
		{
			return false;
		}

		$user = User::model()->findByAttributes(array('username' => $username));

		// Check if user object was found
		if ($user === null)
		{
			return array(1, $user);
		}
		// Check if account is available
		else if (!$user->accountAvailable($user->username))
		{
			return array(2, $user);
		}
		// Check if passwords match
		else if (!CPasswordHelper::verifyPassword($password, $user->password))
		{
			// Store failed login
			$failedLogin = new FailedLogins();

			$failedLogin->ipadress = Yii::app()->getRequest()->getUserHostAddress();
			$failedLogin->datetime = date("Y-m-d H:i:s");
			$failedLogin->user_id  = $user->id;

			$failedLogin->save();

			return array(1, $user);
		}
		// Successful login
		else
		{
			return array(0, $user);
		}
	}

	/**
	 * Outputs a JSON response to the page when authentication has failed,
	 * otherwise returns a user object.
	 *
	 * Uses $this->_getUserAuthentication
	 *
	 * @return $user
	 */
	private function _checkUserAuthentication()
	{
		list($resultCode, $user) = $this->_getUserAuthentication();

		// Successful
		if ($resultCode === 0)
		{
			return $user;
		}
		// Blocked
		else if ($resultCode === 2)
		{
			$this->_sendResponse(200, CJSON::encode(array('message' => 'blocked')));

			return null;
		}

		$this->_sendResponse(200, CJSON::encode(array('message' => 'failed')));

		return null;
	}
}

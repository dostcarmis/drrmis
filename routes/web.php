<?php
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middlewareGroups' => 'web'], function () {	
	Auth::routes();

	Route::get('uploadpage','HomeController@uploadPage');

	Route::group(array('middleware' => 'auth'), function(){
		Route::resource('filemanager', 'FilemanagerLaravelController');
	});
	
	Route::group(['prefix' => 'auth'], function() {
		Route::get('register', [
			'as' => 'get_register',
			'uses' => 'Auth\AuthController@showRegistrationForm'
		]);

		Route::get('province-subcat','Auth\AuthController@registerprovince');
		
		Route::post('register', [
			'as' => 'post_register',
			'uses' => 'Auth\AuthController@postRegister'
		]);
		Route::get('login', [
			'as' => 'get_login',
			'uses' => 'Auth\AuthController@getLogin'
		]);
		Route::post('login', [
			'as' => 'post_login',
			'uses' => 'Auth\LoginController@login'
		]);
		Route::get('logout', [
			'as' => 'get_logout',
			'uses' => 'Auth\AuthController@logout'
		]);
	});

	Route::get('/', [
		'as' => 'home',
		'uses' => 'PagesController@home'
	]);
	Route::get('incicdentsmapview', [
		'as' => 'mapview',
		'uses' => 'PagesController@incidentsMapView'
	]);
	Route::match(['get', 'post'],'dashboard',[
        'uses' => 'HydrometController@dashboard',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM','Staff']
        ]);
	
	Route::match(['get', 'post'], 'viewsensor',[
		'uses' => 'SensorsController@viewSensor',
		'middleware' => 'auth',
	]);

	Route::match(['get', 'post'],'destroymultiplesensors',[
		'uses' => 'SensorsController@destroymultipleSensors',
		'middleware' => 'auth',
	]);
	Route::get('viewpersensor',[
		'uses' => 'HydrometController@viewperSensor',
	]);
	Route::get('addsensor',[
		'uses' => 'SensorsController@viewaddSensor',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'editsensor/{id}', [
		'uses' => 'SensorsController@editSensor',
		'middleware' => 'auth',
	]);
	Route::post('savesensor', [
		'uses' => 'SensorsController@saveSensor',
		'middleware' => 'auth',
	]);
	Route::post('updatesensor',[
		'uses' =>  'SensorsController@updateSensor',
		'middleware' => 'auth',
	]);
	Route::get('destroysensor/{id}',[
		'uses' => 'SensorsController@destroySensor',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'filtersensor',[
		'uses' => 'SensorsController@filterSensor',
	]);

	Route::get('addcategory',[
		'uses' => 'CategoriesController@viewaddCategories',
		'middleware' => 'auth',
	]);
	Route::get('editcategory/{id}',[
		'uses' => 'CategoriesController@editCategory',
		'middleware' => 'auth',
	]);
	Route::post('savecategory', [
		'uses' => 'CategoriesController@saveCategory',
		'middleware' => 'auth',
	]);
	Route::post('updatecategory', [
		'uses' => 'CategoriesController@updateCategory',
		'middleware' => 'auth',
	]);
	Route::get('destroycategory/{id}', [
		'uses' => 'CategoriesController@destroyCategory',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'viewcategories',[
		'uses' => 'CategoriesController@viewCategories',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultiplecategories',[
		'uses' => 'CategoriesController@destroymultipleCategories',
		'middleware' => 'auth',
	]);

	Route::get('addprovince',[
		'uses' => 'ProvinceController@viewaddProvince',
		'middleware' => 'auth',
	]);
	Route::get('editprovince/{id}',[
		'uses' => 'ProvinceController@editProvince',
		'middleware' => 'auth',
	]);
	Route::post('saveprovince', [
		'uses' => 'ProvinceController@saveProvince',
		'middleware' => 'auth',
	]);
	Route::post('updateprovince',[
		'uses' => 'ProvinceController@updateProvince',
		'middleware' => 'auth',
	]);
	Route::get('destroyprovince/{id}', [
		'uses' => 'ProvinceController@destroyProvince',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'viewprovince',[
		'uses' => 'ProvinceController@viewProvince',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultipleprovinces',[
		'uses' => 'ProvinceController@destroymultipleProvinces',
		'middleware' => 'auth',
	]);
	Route::get('addmunicipality',[
		'uses' => 'MunicipalityController@viewaddMunicipality',
		'middleware' => 'auth',
	]);
	Route::get('editmunicipality/{id}',[
		'uses' => 'MunicipalityController@editMunicipality',
		'middleware' => 'auth',
	]);
	Route::post('savemunicipality', [
		'uses' => 'MunicipalityController@saveMunicipality',
		'middleware' => 'auth',
	]);
	Route::post('updatemunicipality', [
		'uses' => 'MunicipalityController@updateMunicipality',
		'middleware' => 'auth',
	]);
	Route::get('destroymunicipality/{id}',[
		'uses' => 'MunicipalityController@destroyMunicipality',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'viewmunicipality',[
		'uses' => 'MunicipalityController@viewMunicipality',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultiplemunicipality',[
		'uses' => 'MunicipalityController@destroymultipleMunicipality',
		'middleware' => 'auth',
	]);

	Route::post('getbrgy', 'MunicipalityController@getbarangays')->middleware('auth')->name('getbrgy');

	Route::match(['get', 'post'],'viewusers',[
		'uses' => 'UserController@viewusers',
		'middleware' => 'auth',
	]);
	Route::get('viewadduser',[
		'uses' => 'UserController@viewadduser',
		'middleware' => 'auth',
	]);
	Route::post('addnewuser',[
		'uses' => 'UserController@addnewuser',
		'middleware' => 'auth',
	]);
	Route::get('viewactivitylogs',[
		'uses' => 'UserlogsController@viewactivitylogs',
		'middleware' => 'auth',
	]);
	Route::get('edituser/{id}', [
		'uses' => 'UserController@edituser',
		'middleware' => 'auth',
	]);
	Route::post('updateuser', [
		'uses' => 'UserController@updateuser',
		'middleware' => 'auth',
	]);
	Route::get('destroyuser/{id}',[
		'uses' => 'UserController@destroyUser',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultipleusers', [
		'uses' => 'UserController@destroymultipleUser',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'filteruser',[
		'uses' => 'UserController@filterUser',
	]);

	// User Groups
	Route::get('usergroups', [
		'uses' => 'UserController@viewGroups',
		'middleware' => 'auth',
	]);
	Route::get('viewcreategroup', [
		'uses' => 'UserController@viewCreateGroup',
		'middleware' => 'auth',
	]);
	Route::get('viewupdategroup/{id}', [
		'uses' => 'UserController@viewUpdateGroup',
		'middleware' => 'auth',
	]);
	Route::post('creategroup',[
		'uses' => 'UserController@createGroup',
		'middleware' => 'auth',
	]);
	Route::post('updategroup',[
		'uses' => 'UserController@updateGroup',
		'middleware' => 'auth',
	]);
	Route::get('deletegroup/{id}',[
		'uses' => 'UserController@deleteGroup',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'deletemultipleGroups', [
		'uses' => 'UserController@deleteMultipleGroups',
		'middleware' => 'auth',
	]);

	Route::match(['get', 'post'],'viewthreshold',[
		'uses' => 'ThresholdController@viewThreshold',
		'middleware' => 'auth',
	]);
	Route::get('viewaddthreshold',[
		'uses' => 'ThresholdController@viewaddThreshold',
		'middleware' => 'auth',
	]);
	Route::post('savethreshold',[
		'uses' => 'ThresholdController@saveThreshold',
		'middleware' => 'auth',
	]);
	Route::get('editthreshold/{id}', [
		'uses' => 'ThresholdController@editThreshold',
		'middleware' => 'auth',
	]);
	Route::post('updatethreshold',[
		'uses' => 'ThresholdController@updateThreshold',
		'middleware' => 'auth',
	]);
	Route::get('destroythreshold/{id}',[
		'uses' => 'ThresholdController@destroyThreshold',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultiplethreshold', [
		'uses' => 'ThresholdController@destroymultipleThreshold',
		'middleware' => 'auth',
	]);

	Route::match(['get', 'post'],'viewfloodproneareas',[
		'uses' => 'FloodproneareasController@viewFloodproneAreas',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultiplefloodproneareas', [
		'uses' => 'FloodproneareasController@destroymultipleFloodproneAreas',
		'middleware' => 'auth',
	]);
	Route::get('destroyfloodpronearea/{id}',[
		'uses' => 'FloodproneareasController@destroyFloodpronearea',
		'middleware' => 'auth',
	]);
	Route::get('viewaddfloodpronearea',[
		'uses' => 'FloodproneareasController@viewaddFloodproneArea',
		'middleware' => 'auth',
	]);
	Route::post('savefloodpronearea',[
		'uses' => 'FloodproneareasController@saveFloodproneArea',
		'middleware' => 'auth',
	]);
	Route::get('editfloodpronearea/{id}', [
		'uses' => 'FloodproneareasController@editFloodproneArea',
		'middleware' => 'auth',
	]);
	Route::post('updatefloodpronearea', [
		'uses' => 'FloodproneareasController@updateFloodproneArea',
		'middleware' => 'auth',
	]);

	Route::match(['get', 'post'],'viewthresholdflood',[
		'uses' => 'ThresholdFlood@viewThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'destroymultiplethresholdflood', [
		'uses' => 'ThresholdFlood@destroymultipleThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::get('viewaddthresholdflood',[
		'uses' => 'ThresholdFlood@viewaddThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::post('savethresholdflood',[
		'uses' => 'ThresholdFlood@saveThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::get('editthresholdflood/{id}', [
		'uses' => 'ThresholdFlood@editThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::post('updatethresholdflood',[
		'uses' => 'ThresholdFlood@updateThresholdFlood',
		'middleware' => 'auth',
	]);
	Route::get('destroythresholdflood/{id}',[
		'uses' => 'ThresholdFlood@destroyThresholdFlood',
		'middleware' => 'auth',
	]);
	
	Route::match(['get', 'post'],'destroymultiplesusceptibility',[
		'uses' => 'SusceptibilityController@destroymultipleSusceptibility',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'viewsusceptibility',[
		'uses' => 'SusceptibilityController@viewSusceptibility',
		'middleware' => 'auth',
	]);
	Route::get('viewaddsusceptibility',[
		'uses' => 'SusceptibilityController@viewaddSusceptibility',
		'middleware' => 'auth',
	]);
	Route::post('savesusceptibility',[
		'uses' => 'SusceptibilityController@saveSusceptibility',
		'middleware' => 'auth',
	]);
	Route::get('editsusceptibility/{id}', [
		'uses' => 'SusceptibilityController@editSusceptibility',
		'middleware' => 'auth',
	]);
	Route::post('updatesusceptibility',[
		'uses' => 'SusceptibilityController@updateSusceptibility',
		'middleware' => 'auth',
	]);
	Route::get('destroysusceptibility/{id}', [
		'uses' => 'SusceptibilityController@destroySusceptibility',
		'middleware' => 'auth',
	]);

	//Report Generation Routes
	Route::get('report',[
		'uses' => 'ReportController@showReport',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::post('report/display-sensor-location',[
		'uses' => 'ReportController@getSensorLocation',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::post('report/generate-threshold', [
		'uses' => 'ReportController@getSensorThreshold',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::post('report/generate-data', [
		'uses' => 'ReportController@initializeDataGeneration',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::get('report/test',[
		'uses' => 'ReportController@test',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//SMS Module Routes
	/*
	Route::get('warn/test-semaphore',[
		'uses' => 'SMSController@testSemaphore',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);*/
	Route::get('warn/notification-subscribers',[
		'uses' => 'SMSController@viewNotificationSubscribers',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/notifications',[
		'uses' => 'SMSController@viewAllNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::get('warn/contacts',[
		'uses' => 'SMSController@viewRegisteredContacts',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/compose-message',[
		'uses' => 'SMSController@viewComposeMessage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/queued-msg/count',[
		'uses' => 'SMSController@getQueuedMsgCount',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/queued-msg/delete',[
		'uses' => 'SMSController@deleteQueuedMsg',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/sent-messages',[
		'uses' => 'SMSController@viewSentMessages',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::any('destroymultiplesentmessages', [
		'uses' => 'SMSController@destroymultipleSentMsgs',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/get-sender-names',[
		'uses' => 'SMSController@getSenderNames',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	
	Route::get('warn/subscribe',[
		'uses' => 'SMSController@viewSubscribe',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/success-subscribe',[
		'uses' => 'SMSController@viewSuccessSubscribe',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('warn/web-subscribe',[
		'uses' => 'SMSController@webSubscribe',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/send',[
		'uses' => 'SMSController@sendMessage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/get-recipients',[
		'uses' => 'SMSController@getRecipients',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/get-notification',[
		'uses' => 'SMSController@getNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/add-subscriber',[
		'uses' => 'SMSController@addSubscriber',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/check-subscribed',[
		'uses' => 'SMSController@checkSubscribed',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('warn/unsubscribed',[
			'uses' => 'SMSController@unsubscribeUser',
			'middleware' => 'roles',
			'roles' => ['Developer','PDRRM','Admin','MDRRM','Staff']
	]);
	

	Route::get('aboutpage', 'PagesController@aboutpage');






	//MINER
	Route::get('minerpage',[ 
		'uses' => 'PagesController@minerPage',
		'middleware' => 'auth',
	]);
	
	Route::post('saveminer', [
		'uses' => 'PagesController@saveMiner',
		'middleware' => 'auth',
	]);
	Route::post('getsensorlist', 'PagesController@getSensorList')->middleware('auth')->name('getsensorlist');
	Route::post('saveminer2','PagesController@saveMiner2')->middleware('auth')->name('startmining');

	// Route::post('getsensorlist', [
	// 	'uses' => 'PagesController@getSensorList',
	// 	'middleware' => 'roles',
	// 	'roles' => ['Developer']
	// ]);









	Route::post('generatekml', [
		'uses' => 'IncidentsController@generateKml',
		'middleware' => 'auth',
	]);
	
	Route::get('debuggenerate',[ 
		'uses' => 'GenerateKmlController@viewpageGenerate',
		'middleware' => 'auth',
	]);
	Route::post('postgenerate',[ 
		'uses' => 'GenerateKmlController@postGenerate',
		'middleware' => 'auth',
	]);

	Route::post('updateprofile',[
		'uses' => 'UserController@updateProfile',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('profile',[
		'uses' => 'UserController@profile',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	
	Route::match(['get', 'post'],'viewroadnetworks',[
        'uses' => 'RoadController@viewRoadnetworks',
    ]);
	Route::match(['get', 'post'],'viewroadnetworksmonitoring',[
        'uses' => 'RoadController@viewRoadnetworksmonitoring',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get', 'post'],'ajaxhydromet',[
        'uses' => 'HydrometController@ajaxHydromet',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get', 'post'],'ajaxwaterlvl',[
        'uses' => 'HydrometController@ajaxWaterlvl',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get','post'],'viewhydrometdata',[
        'uses' => 'HydrometController@viewHydrometdata',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get','post'],'viewhydrometdatawaterlevel',[
        'uses' => 'HydrometController@viewHydrometdatawaterlevel',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::get('addroadnetwork',[
		'uses' => 'RoadController@viewaddRoadnetwork',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('searchroadnetwork',[
		'uses' => 'RoadController@searchRoadnetwork',
	]);
	Route::post('saveroadnetwork', [
		'uses' => 'RoadController@saveRoadnetwork',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'editroadnetwork/{id}', [
		'uses' => 'RoadController@editRoadnetwork',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updateroadnetwork',[
		'uses' =>  'RoadController@updateRoadnetwork',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroyroadnetwork/{id}', [
		'uses' => 'RoadController@destroyRoadnetwork',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultipleroadnetworks',[
		'uses' => 'RoadController@destroymultipleRoadnetworks',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::match(['get', 'post'],'viewperlandslide/{id}', [
		'uses' => 'LandslideController@viewperLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'viewmultiplelandslides',[
        'uses' => 'LandslideController@viewmultipleLandslides',        
    ]);
	Route::match(['get', 'post'],'viewlandslides',[
        'uses' => 'LandslideController@viewLandslides',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
        ]);
	Route::match(['get', 'post'],'viewlandslidereports',[
        'uses' => 'LandslideController@viewReportLandslide',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);

	Route::match(['get', 'post'],'destroymultiplelandslides',[
		'uses' => 'LandslideController@destroymultipleLandslides',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'addlandslide',[
		'uses' => 'LandslideController@viewaddLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('savelandslide', [
		'uses' => 'LandslideController@saveLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('filterlandslidereport', [
		'uses' => 'LandslideController@filterLandslideReport',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'editlandslide/{id}', [
		'uses' => 'LandslideController@editLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updatelandslide',[
		'uses' =>  'LandslideController@updateLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroylandslide/{id}', [
		'uses' => 'LandslideController@destroyLandslide',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('uploadlandslideimage', [
		'uses' => 'LandslideController@uploadLandslideimage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('editlandslide/{id}/edituploadlandslideimage', [
		'uses' => 'LandslideController@edituploadLandslideimage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('province-show','LandslideController@showprovince');

	Route::match(['get', 'post'],'viewfloods',[
        'uses' => 'FloodController@viewFloods',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get', 'post'],'viewfloodreports',[
        'uses' => 'FloodController@viewFloodLandslide',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::post('filterfloodreport', [
		'uses' => 'FloodController@filterFloodReport',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::match(['get', 'post'],'editflood/{id}', [
		'uses' => 'FloodController@editFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updateflood',[
		'uses' =>  'FloodController@updateFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroyflood/{id}', [
		'uses' => 'FloodController@destroyFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'addflood',[
		'uses' => 'FloodController@viewaddFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('saveflood', [
		'uses' => 'FloodController@saveFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultiplefloods',[
		'uses' => 'FloodController@destroymultipleFloods',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'viewperflood/{id}', [
		'uses' => 'FloodController@viewperFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'viewmultiplefloods',[
        'uses' => 'FloodController@viewmultipleFloods',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::post('uploadfloodimages', [
		'uses' => 'FloodController@uploadFloodimages',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('editflood/{id}/edituploadfloodimage', [
		'uses' => 'FloodController@edituploadFloodimage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::match(['get', 'post'],'filterdata',[
		'uses' => 'HydrometController@Filterdata',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('view', [
		'uses' => 'ProvinceController@saveProvince',
		'middleware' => 'auth',
	]);

	Route::get('ajax-subcat','SensorsController@duplicate');
	Route::get('/ajax-subcat/{id}','SensorsController@duplicateedit');
	
	Route::get('notificationsmob', [
		'uses' => 'NotificationsController@viewmobileNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('viewnotifications', [
		'uses' => 'NotificationsController@viewNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'seenotifications', [
		'uses' => 'NotificationsController@seeNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('readnotifications', [
		'uses' => 'NotificationsController@readNotifications',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('viewnotification/{id}',[
		'uses' => 'NotificationsController@viewNotification',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('viewnotificationflood/{id}',[
		'uses' => 'NotificationsController@viewNotificationFlood',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('ajax-notif',[
		'uses' => 'NotificationsController@ajaxnotif',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('displaycount',[
		'uses' => 'NotificationsController@displayCount',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('notification', [
		'uses' => 'NotificationsController@displaynotif',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('viewmultiplecharts', [
		'uses' => 'ChartController@viewmultipleCharts',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	
	Route::match(['get', 'post'],'filterchart',[
		'uses' => 'ChartController@filterChart',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::get('cn','NotificationsController@myNotifications');

	Route::get('viewhazardmaps',[
		'uses' => 'HazardmapsController@viewHazardmaps',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('addhazardmap',[
		'uses' => 'HazardmapsController@addHazardmap',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('savehazardmap',[
		'uses' => 'HazardmapsController@saveHazardmap',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updatehazardmap',[
		'uses' => 'HazardmapsController@updateHazardmap',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultiplehazardmaps',[
		'uses' => 'HazardmapsController@destroymultipleHazardmaps',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroyhazardmap/{id}',[
		'uses' => 'HazardmapsController@destroyHazardmap',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'edithazardmap/{id}', [
		'uses' => 'HazardmapsController@editHazardmap',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('viewhazards',[
		'uses' => 'HazardsController@viewHazards',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('savehazard',[
		'uses' => 'HazardsController@saveHazard',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('addhazard',[
		'uses' => 'HazardsController@viewaddHazard',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'edithazard/{id}', [
		'uses' => 'HazardsController@editHazard',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updatehazard',[
		'uses' => 'HazardsController@updateHazard',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroyhazard/{id}',[
		'uses' => 'HazardsController@destroyHazard',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultiplehazards',[
		'uses' => 'HazardsController@destroymultipleHazards',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	
	//incidents (useless routes)
	Route::match(['get', 'post'],'incidents',[
		'uses' => 'IncidentsController@viewIncidents',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('addincident',[
		'uses' => 'IncidentsController@viewaddIncident',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('uploadincidentimage', [
		'uses' => 'IncidentsController@uploadIncidentimage',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('saveincident',[
		'uses' => 'IncidentsController@saveIncident',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updateincident',[
		'uses' => 'IncidentsController@updateIncident',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'editincident/{slug}', [
		'uses' => 'IncidentsController@editIncident',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	Route::match(['get', 'post'],'incident/{slug}', [
		'uses' => 'IncidentsController@viewperIncident',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroyincident/{id}', [
		'uses' => 'IncidentsController@destroyIncident',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultipleincidents',[
		'uses' => 'IncidentsController@destroymultipleIncidents',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//fire
	Route::get('addfire',[
		'uses' => 'FiresController@viewaddFire',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('savefire',[
		'uses' => 'FiresController@savefire',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM'],
	])->name('savefire');
	Route::post('uploadfireimages', [
		'uses' => 'FiresController@uploadFireImages',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//vehicular
	Route::get('addvehicular',[
		'uses' => 'VehicularController@viewaddvehicular',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('savevehicular',[
		'uses' => 'VehicularController@savevehicular',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM'],
	])->name('savevehicular');
	Route::post('uploadvehicularimages', [
		'uses' => 'VehicularController@uploadvehicularImages',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//typhoon
	Route::match(['get', 'post'],'ajaxtyphoontrack',[
        'uses' => 'TyphoontrackController@ajaxtyphoontrack',
        'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
    ]);
	Route::match(['get', 'post'],'viewtyphoontracks',[
		'uses' => 'TyphoontrackController@viewTyphoonTracks',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'addtyphoontracks',[
		'uses' => 'TyphoontrackController@viewaddTyphoonTracks',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'savetyphoon',[
		'uses' => 'TyphoontrackController@saveTyphoonTrack',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'statuschange',[
		'uses' => 'TyphoontrackController@status',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('updatetyphoon',[
		'uses' => 'TyphoontrackController@updateTyphoonTrack',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::get('destroytyphoon/{id}',[
		'uses' => 'TyphoontrackController@destroyTyphoon',
		'middleware' => 'auth',
	]);
	Route::match(['get', 'post'],'edittyphoontrack/{id}', [
		'uses' => 'TyphoontrackController@editTyphoonTracks',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'destroymultipletyphoons', [
		'uses' => 'TyphoontrackController@destroymultipleTyphoons',
		'middleware' => 'auth',
	]);

	//preparedness pages
	Route::match(['get', 'post'],'preparedness',[
		'uses' => 'PreparednessController@viewPreparedness',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'deletepreparedness/{id}',[
		'uses' => 'PreparednessController@deletPreparedness',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'savepreparedness',[
		'uses' => 'PreparednessController@savePreparedness',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//response pages
	Route::match(['get', 'post'],'response',[
		'uses' => 'ResponseController@viewResponse',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'deleteresponse/{id}',[
		'uses' => 'ResponseController@deletResponse',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'saveresponse',[
		'uses' => 'ResponseController@saveResponse',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//rehab pages
	Route::post('saverehab','RehabilitationController@saveRehabilitation')->name('saverehab');
	
	Route::match(['get', 'post'],'rehabilitationnrecovery',[
		'uses' => 'RehabilitationController@viewRehabilitation',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'deleterehab/{id}',[
		'uses' => 'RehabilitationController@deletRehab',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	/* Route::match(['get', 'post'],'saverehab',[
		'uses' => 'RehabilitationController@saveRehabilitation',
		'middleware' => 'roles',
		'roles' => ['Developer','PDRRM','Admin','MDRRM'],
	]); */

	//DRRM fileDownload pages
	Route::match(['get'],'filedownloadpage',[
		'uses' => 'FileDownloadController@viewFiledownload',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('viewfiles', 'FileDownloadController@viewFiledownload')->middleware('auth')->name('km-viewfiles');
	Route::post('savefiles', 'FileDownloadController@saveFile')->middleware('auth')->name('km-savefiles');
	

	Route::match(['get', 'post'],'filedownloadpage/deletefile/{id}',[
		'uses' => 'FileDownloadController@deleteFile',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);

	//sitreps
	Route::match(['get', 'post'],'sitreps',[
		'uses' => 'SitrepController@viewallsitreps',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::post('sitrep-viewfiles', 'SitrepController@mainviewsitreps')->middleware('auth')->name('sitrep-viewfiles');
	Route::match(['get', 'post'],'sitreps/{sitrep_level}',[
		'uses' => 'SitrepController@mainviewsitreps',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'savesitrepfile',[
		'uses' => 'SitrepController@savesitrepfile',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'sitreps/deletesitrep/{id}',[
		'uses' => 'SitrepController@deleteSitrep',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);	
	
	//risk assess pages
	Route::match(['get', 'post'],'riskassessmentfiles/{province_id}/{municipal_id}',[
		'uses' => 'RiskassessController@viewFiles',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'saverehab',[
		'uses' => 'RiskassessController@saveRiskassess',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	Route::match(['get', 'post'],'riskassessmentfiles/deleterisk/{id}',[
		'uses' => 'RiskassessController@deleteRiskfile',
		'middleware' => 'auth', //'roles'
		// 'roles' => ['Developer','PDRRM','Admin','MDRRM']
	]);
	/*==============CLEARS ROUTES================*/
	Route::post('clears-show', 'ClearsController@show');
	Route::post('clears-audit', 'ClearsController@showAudit')->middleware('auth')->name('c-audit');;
	Route::post('clears-save', 'ClearsController@save')->middleware('auth')->name('c-save');
	Route::post('clears-update', 'ClearsController@update')->middleware('auth')->name('c-update');
	Route::post('clears-delete', 'ClearsController@delete')->middleware('auth')->name('c-delete');
	Route::post('clears-filter', 'ClearsController@filter')->middleware('auth')->name('c-filter');

	/*==============MODULE ACCESS ROUTES================*/
	Route::post('user-accesses', 'RoleModulesController@show')->middleware('auth');
	Route::post('ma-search', 'RoleModulesController@search')->middleware('auth')->name('ma-search');
	Route::post('ma-save', 'RoleModulesController@save')->middleware('auth')->name('ma-save');

	Route::post('modules', 'ModulesController@show')->middleware('auth')->name('modules');
	Route::post('modules-crud', 'ModulesController@crud')->middleware('auth')->name('modules-crud');
	Route::post('modules-userlist', 'ModulesController@userlist')->middleware('auth')->name('modules-userlist');
	Route::post('modules-edit', 'ModulesController@editform')->middleware('auth')->name('modules-edit');

	Route::post('modules-update', 'ModuleDefaultsController@update')->middleware('auth')->name('modules-update');
	Route::post('save-module', 'ModuleDefaultsController@save')->middleware('auth')->name('save-module');

	/*==============ROLES ROUTES================*/
	Route::post('rolesmgmt', 'RoleController@show')->middleware('auth')->name('rolesmgmt');
	Route::post('role-save', 'RoleController@save')->middleware('auth')->name('role-save');
	Route::post('role-update', 'RoleController@update')->middleware('auth')->name('role-update');
	Route::post('role-delete', 'RoleController@delete')->middleware('auth')->name('role-delete');

	/*==============TEST ROUTES================*/

	Route::get('media-2', 'OtherController@index');
	Route::get('viewtestsite','PagesController@viewTestsite');
	Route::get('media', ['as' => 'image.create', 'uses' => 'ImageController@create']);
	Route::post('/upload', ['as' => 'image.store' , 'uses' => 'ImageController@store']);

	Route::get('starto', [
		'as' => 'starto',
		'uses' => 'LandslideController@syncDataFromIncidentToLandslide'
	]);

	Route::get('startoF', [
		'as' => 'startoF',
		'uses' => 'FloodController@syncDataFromIncidentToFlood'
	]);

});
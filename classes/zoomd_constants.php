<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
define('BASE_URL', get_bloginfo('url'));

const baseURL = 'http://zadmin.zoomd.com';
const widgetbaseURL = 'zsearch.zoomd.com';

define('PostApiEndpointVal', baseURL . '/api/Wordpress/Upload');
define('GetApiEndpointVal', baseURL . '/api/Wordpress');
define('ValidateEndpointVal', baseURL . '/api/Wordpress/Validate');
define('UnRegisterEndpointVal', baseURL . '/api/Wordpress/UnRegister');
define('DeactivateEndpointVal', baseURL . '/api/Wordpress/Deactivate');
define('RegistrationEndpointVal', baseURL . '/SelfService/Wordpress?url=');


const LASTINDEXED =  'zoomd_last_index_time';
const PostApiEndpoint = PostApiEndpointVal;
const GetApiEndpoint = GetApiEndpointVal;
const ValidationEndpoint = ValidateEndpointVal;
const RegistrationEndPoint = RegistrationEndpointVal;
const logglyUrl = 'https://logs-01.loggly.com/bulk/2f471b20-4cdf-4a0b-ba5b-dcaeb14206d2/tag/WordPress';


const MaxBatchSize = 15;

?>
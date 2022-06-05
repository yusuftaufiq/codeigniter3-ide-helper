<?php

/**
 * @property CI_Session $session
 * @property CI_Email $email
 * @property CI_User_agent $ua
 * @property User $User
 * @property Role $role
 * @property CI_Benchmark $benchmark
 * @property CI_Cache $cache
 * @property CI_Config $config
 * @property CI_DB $db
 * @property CI_Input $input
 * @property CI_Lang $lang
 * @property CI_Loader $load
 * @property CI_Output $output
 * @property CI_Security $security
 * @property CI_URI $uri
 */
class CI_Controller
{
}
/**
 * @property CI_Session $session
 * @property CI_Email $email
 * @property CI_User_agent $ua
 * @property User $User
 * @property Role $role
 * @property CI_Benchmark $benchmark
 * @property CI_Cache $cache
 * @property CI_Config $config
 * @property CI_DB $db
 * @property CI_Input $input
 * @property CI_Lang $lang
 * @property CI_Loader $load
 * @property CI_Output $output
 * @property CI_Security $security
 * @property CI_URI $uri
 */
class CI_Model
{
}
/**
 * @property CI_Session $session
 * @property CI_Session $app_session
 * @property CI_Session $app_session
 * @property CI_Session $app_session
 * @property CI_Session $app_session
 * @property CI_Session $app_session
 * @property CI_Email $app_email
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_Email $email
 * @property CI_Form_validation $form_validation
 * @property CI_Email $app_email
 * @property CI_Form_validation $app_form_validation
 * @property Role $Role
 * @property User $User
 * @property User $user
 * @property User $user
 * @property User $user
 * @property User $user
 */
class MY_Controller extends CI_Controller
{
}
/**
 * @property CI_Encryption $encrypt
 */
class AuthController extends MY_Controller
{
}
/**
 * @property CI_Upload $upload
 */
class User extends CI_Model
{
}
/**
 * @property CI_Profiler $profiler
 */
class Role extends CI_Model
{
}